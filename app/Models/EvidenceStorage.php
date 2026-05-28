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
}
