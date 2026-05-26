<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'qr_code',
        'name',
        'sku',
        'price',
        'stock',
        'type',
        'location',
        'description',
    ];

    public function scanLogs()
    {
        return $this->hasMany(ScanLog::class);
    }
}
