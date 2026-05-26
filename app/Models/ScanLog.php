<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanLog extends Model
{
    public const ACTION_VIEW = 'view';
    public const ACTION_IMPORT_STOCK = 'import_stock';
    public const ACTION_EXPORT_STOCK = 'export_stock';
    public const ACTION_CHECK_STOCK = 'check_stock';

    public const ACTIONS = [
        self::ACTION_VIEW,
        self::ACTION_IMPORT_STOCK,
        self::ACTION_EXPORT_STOCK,
        self::ACTION_CHECK_STOCK,
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
