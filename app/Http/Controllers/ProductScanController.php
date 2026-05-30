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
        $storages = \App\Models\EvidenceStorage::orderBy('storage_code')->get();

        return view('products.mobile-scan', compact('storages'));
    }

    public function findByQrCode(Request $request, $code)
    {
        $request->validate([
            'action' => [
                'nullable',
                \Illuminate\Validation\Rule::in(\App\Models\ScanLog::ACTIONS),
            ],
            'storage_location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'receiver_name' => [
                'nullable',
                'string',
                'max:255',
            ],
            'return_type' => [
                'nullable',
                'in:return,destroy',
            ],
            'note' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'evidence_storage_id' => [
                'nullable',
                'exists:evidence_storages,id',
            ],
        ]);

        $action = $request->input('action', \App\Models\ScanLog::ACTION_VIEW);

        $user = $request->user();

        if ($action === \App\Models\ScanLog::ACTION_IMPORT_STORAGE) {
            if (!$user->hasRole([
                \App\Models\User::ROLE_STORAGE_KEEPER,
                \App\Models\User::ROLE_COMMANDER,
            ])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền nhập kho vật chứng.',
                ], 403);
            }
        }

        if ($action === \App\Models\ScanLog::ACTION_HANDOVER_ASSESSMENT) {
            if (!$user->hasRole([
                \App\Models\User::ROLE_COMMANDER,
            ])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ huy mới có quyền phê duyệt xuất bàn giao giám định.',
                ], 403);
            }
        }

        if ($action === \App\Models\ScanLog::ACTION_RETURN_DESTROY) {
            if (!$user->hasRole([
                \App\Models\User::ROLE_COMMANDER,
                \App\Models\User::ROLE_STORAGE_KEEPER,
            ])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn không có quyền hoàn trả hoặc tiêu huỷ vật chứng.',
                ], 403);
            }
        }

        $product = \App\Models\Product::where('qr_code', $code)->first();

        if (!$product) {
            \App\Models\ScanLog::create([
                'product_id' => null,
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'qr_code' => $code,
                'action' => $action,
                'note' => 'Không tìm thấy mẫu vật chứng',
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 500),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy mẫu vật chứng với mã: ' . $code,
            ], 404);
        }

        $stockBefore = $product->stock;
        $stockAfter = $product->stock;

        \Illuminate\Support\Facades\DB::transaction(function () use (
            $request,
            $product,
            $code,
            $action,
            $stockBefore,
            &$stockAfter
        ) {
            if ($action === \App\Models\ScanLog::ACTION_IMPORT_STORAGE) {
                $product->storage_status = \App\Models\Product::STORAGE_STATUS_IN_STORAGE;
                $product->stock = 1;

                if ($request->filled('evidence_storage_id')) {
                    $product->evidence_storage_id = $request->evidence_storage_id;
                }

                if ($request->filled('storage_location')) {
                    $product->location = $request->storage_location;
                }

                $product->save();
                $stockAfter = $product->stock;
            }

            if ($action === \App\Models\ScanLog::ACTION_HANDOVER_ASSESSMENT) {
                if ($product->storage_status !== \App\Models\Product::STORAGE_STATUS_IN_STORAGE) {
                    abort(422, 'Mẫu vật chứng không ở trạng thái đang lưu kho, không thể bàn giao giám định.');
                }

                $product->storage_status = \App\Models\Product::STORAGE_STATUS_ASSESSMENT;
                $product->stock = 0;
                $product->save();

                $stockAfter = $product->stock;
            }

            if ($action === \App\Models\ScanLog::ACTION_RETURN_DESTROY) {
                $returnType = $request->input('return_type', 'return');

                if ($returnType === 'destroy') {
                    $product->storage_status = \App\Models\Product::STORAGE_STATUS_DESTROYED;
                    $product->stock = 0;
                } else {
                    $product->storage_status = \App\Models\Product::STORAGE_STATUS_RETURNED;
                    $product->stock = 0;
                }

                $product->save();

                $stockAfter = $product->stock;
            }

            $noteParts = [];

            if ($request->filled('storage_location')) {
                $noteParts[] = 'Vị trí lưu trữ: ' . $request->storage_location;
            }

            if ($request->filled('receiver_name')) {
                $noteParts[] = 'Người nhận: ' . $request->receiver_name;
            }

            if ($request->filled('return_type')) {
                $noteParts[] = 'Hình thức: ' . (
                    $request->return_type === 'destroy' ? 'Tiêu huỷ' : 'Hoàn trả'
                    );
            }

            if ($request->filled('note')) {
                $noteParts[] = 'Ghi chú: ' . $request->note;
            }

            if ($request->filled('evidence_storage_id')) {
                $storage = \App\Models\EvidenceStorage::find($request->evidence_storage_id);

                if ($storage) {
                    $noteParts[] = 'Kho lưu trữ: ' . $storage->storage_code . ' - ' . $storage->name;
                }
            }

            \App\Models\ScanLog::create([
                'product_id' => $product->id,
                'user_id' => \Illuminate\Support\Facades\Auth::id(),
                'qr_code' => $code,
                'action' => $action,
                'quantity' => 1,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'note' => implode(' | ', $noteParts),
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
                'type' => $product->type,
                'type_name' => $product->type_name,
                'sku' => $product->sku,
                'location' => $product->location,
                'description' => $product->description,
                'storage_status' => $product->storage_status,
                'storage_status_name' => $product->storage_status_name,
                'case_code' => optional($product->caseFile)->case_code,
                'case_title' => optional($product->caseFile)->title,
            ],
        ]);
    }

    public function qrCodes()
    {
        $products = \App\Models\Product::orderBy('qr_code')->get();

        return view('products.qrcodes', compact('products'));
    }
}
