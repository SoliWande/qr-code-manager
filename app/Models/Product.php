<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public const TYPE_OTHER = 1;
    public const TYPE_DOCUMENT = 2;
    public const TYPE_OBJECT = 3;
    public const TYPE_IMAGE = 4;
    public const TYPE_DIGITAL = 5;

    public const TYPES = [
        self::TYPE_OTHER => 'Khác',
        self::TYPE_DOCUMENT => 'Tài liệu',
        self::TYPE_OBJECT => 'Đồ vật',
        self::TYPE_IMAGE => 'Hình ảnh',
        self::TYPE_DIGITAL => 'Dữ liệu điện tử',
    ];

    public const STORAGE_STATUS_IN_STORAGE = 'in_storage';
    public const STORAGE_STATUS_ASSESSMENT = 'assessment';
    public const STORAGE_STATUS_RETURNED = 'returned';
    public const STORAGE_STATUS_DESTROYED = 'destroyed';

    public const STORAGE_STATUS_LABELS = [
        self::STORAGE_STATUS_IN_STORAGE => 'Đang lưu kho',
        self::STORAGE_STATUS_ASSESSMENT => 'Đang giám định',
        self::STORAGE_STATUS_RETURNED => 'Đã hoàn trả',
        self::STORAGE_STATUS_DESTROYED => 'Đã tiêu huỷ',
    ];
    protected $fillable = [
        'case_file_id',
        'evidence_storage_id',
        'storage_status',
        'qr_code',
        'name',
        'sku',
        'price',
        'stock',
        'location',
        'description',
    ];

    public function storage()
    {
        return $this->belongsTo(EvidenceStorage::class, 'evidence_storage_id');
    }

    public function caseFile()
    {
        return $this->belongsTo(CaseFile::class);
    }

    public function scanLogs()
    {
        return $this->hasMany(ScanLog::class);
    }

    public function getTypeNameAttribute()
    {
        return self::TYPES[$this->type] ?? 'Không xác định';
    }

    public function getStorageStatusNameAttribute()
    {
        return self::STORAGE_STATUS_LABELS[$this->storage_status] ?? 'Không xác định';
    }
}
