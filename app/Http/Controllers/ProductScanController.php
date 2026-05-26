<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ScanLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductScanController extends Controller
{
    public function index()
    {
        return view('products.mobile-scan');
    }

    public function findByQrCode(Request $request, $code)
    {
        $request->validate([
            'action' => [
                'nullable',
                Rule::in(ScanLog::ACTIONS),
            ],
            'quantity' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'note' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $action = $request->input('action', ScanLog::ACTION_VIEW);
        $quantity = $request->input('quantity');

        $product = Product::where('qr_code', $code)->first();

        if (!$product) {
            ScanLog::create([
                'product_id' => null,
                'user_id' => Auth::id(),
                'qr_code' => $code,
                'action' => $action,
                'quantity' => $quantity,
                'note' => 'Không tìm thấy sản phẩm',
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 500),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy sản phẩm với mã: ' . $code,
            ], 404);
        }

        $stockBefore = $product->stock;
        $stockAfter = $stockBefore;

        DB::transaction(function () use (
            $request,
            $product,
            $code,
            $action,
            $quantity,
            $stockBefore,
            &$stockAfter
        ) {
            if ($action === ScanLog::ACTION_IMPORT_STOCK) {
                if (!$quantity) {
                    abort(422, 'Vui lòng nhập số lượng cần nhập kho.');
                }

                $product->stock += $quantity;
                $product->save();

                $stockAfter = $product->stock;
            }

            if ($action === ScanLog::ACTION_EXPORT_STOCK) {
                if (!$quantity) {
                    abort(422, 'Vui lòng nhập số lượng cần xuất kho.');
                }

                if ($product->stock < $quantity) {
                    abort(422, 'Tồn kho không đủ để xuất.');
                }

                $product->stock -= $quantity;
                $product->save();

                $stockAfter = $product->stock;
            }

            ScanLog::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'qr_code' => $code,
                'action' => $action,
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'note' => $request->input('note'),
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 500),
            ]);
        });

        $product->refresh();

        return response()->json([
            'success' => true,
            'message' => 'Thao tác thành công',
            'product' => [
                'id' => $product->id,
                'qr_code' => $product->qr_code,
                'name' => $product->name,
                'sku' => $product->sku,
                'price' => $product->price,
                'stock' => $product->stock,
                'type' => $product->type,
                'location' => $product->location,
                'description' => $product->description,
            ],
        ]);
    }

    public function qrCodes()
    {
        $products = \App\Models\Product::orderBy('qr_code')->get();

        return view('products.qrcodes', compact('products'));
    }
}
