<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Quản trị hệ thống',
                'email' => 'admin@example.com',
                'password' => '12345678',
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => 'Cán bộ khám nghiệm',
                'email' => 'scene@example.com',
                'password' => '12345678',
                'role' => User::ROLE_SCENE_OFFICER,
            ],
            [
                'name' => 'Cán bộ kho vật chứng',
                'email' => 'storage@example.com',
                'password' => '12345678',
                'role' => User::ROLE_STORAGE_KEEPER,
            ],
            [
                'name' => 'Kỹ thuật viên giám định',
                'email' => 'lab@example.com',
                'password' => '12345678',
                'role' => User::ROLE_LAB_TECHNICIAN,
            ],
            [
                'name' => 'Chỉ huy phê duyệt',
                'email' => 'commander@example.com',
                'password' => '12345678',
                'role' => User::ROLE_COMMANDER,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                [
                    'email' => $user['email'],
                ],
                [
                    'name' => $user['name'],
                    'password' => Hash::make($user['password']),
                    'role' => $user['role'],
                ]
            );
        }
    }
}
