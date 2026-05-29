<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_SCENE_OFFICER = 'scene_officer';
    public const ROLE_LAB_TECHNICIAN = 'lab_technician';
    public const ROLE_COMMANDER = 'commander';
    public const ROLE_STORAGE_KEEPER = 'storage_keeper';

    public const ROLES = [
        self::ROLE_ADMIN => 'Quản trị hệ thống',
        self::ROLE_SCENE_OFFICER => 'Cán bộ khám nghiệm',
        self::ROLE_LAB_TECHNICIAN => 'Kỹ thuật viên / cán bộ giám định',
        self::ROLE_COMMANDER => 'Chỉ huy phê duyệt',
        self::ROLE_STORAGE_KEEPER => 'Cán bộ kho vật chứng',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }

        return in_array($this->role, $roles, true);
    }

    public function getRoleNameAttribute(): string
    {
        return self::ROLES[$this->role] ?? 'Không xác định';
    }
}
