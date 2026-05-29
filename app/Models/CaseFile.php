<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseFile extends Model
{
    protected $fillable = [
        'case_code',
        'title',
        'scene_location',
        'officer_name',
        'case_date',
        'description',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_user_id');
    }
}
