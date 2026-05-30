<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvidenceStorage extends Model
{
    protected $fillable = [
        'storage_code',
        'name',
        'location',
        'description',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'evidence_storage_id');
    }
}
