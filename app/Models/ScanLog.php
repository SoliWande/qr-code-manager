<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanLog extends Model
{
    public const ACTION_VIEW = 'view';
    public const ACTION_IMPORT_STORAGE = 'import_storage';
    public const ACTION_HANDOVER_ASSESSMENT = 'handover_assessment';
    public const ACTION_RETURN_DESTROY = 'return_destroy';

    public const ACTION_IMPORT_STOCK = 'import_stock';
    public const ACTION_EXPORT_STOCK = 'export_stock';
    public const ACTION_CHECK_STOCK = 'check_stock';

    public const ACTIONS = [
        self::ACTION_VIEW,
        self::ACTION_IMPORT_STORAGE,
        self::ACTION_HANDOVER_ASSESSMENT,
        self::ACTION_RETURN_DESTROY,
        self::ACTION_IMPORT_STOCK,
        self::ACTION_EXPORT_STOCK,
        self::ACTION_CHECK_STOCK,
    ];

    public const ACTION_LABELS = [
        self::ACTION_VIEW => 'Xem thông tin',
        self::ACTION_IMPORT_STORAGE => 'Nhập kho vật chứng',
        self::ACTION_HANDOVER_ASSESSMENT => 'Xuất bàn giao giám định',
        self::ACTION_RETURN_DESTROY => 'Hoàn trả / Tiêu huỷ',
    ];

    protected $fillable = [
        'product_id',
        'user_id',
        'qr_code',
        'action',
        'quantity',
        'stock_before',
        'stock_after',
        'note',
        'ip_address',
        'user_agent',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
