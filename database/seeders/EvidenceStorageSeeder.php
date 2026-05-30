<?php

namespace Database\Seeders;

use App\Models\EvidenceStorage;
use Illuminate\Database\Seeder;

class EvidenceStorageSeeder extends Seeder
{
    public function run(): void
    {
        $storages = [
            [
                'storage_code' => 'KHO-A',
                'name' => 'Kho vật chứng A',
                'location' => 'Tầng 1 - Phòng lưu vật chứng',
                'description' => 'Kho lưu vật chứng thông thường.',
            ],
            [
                'storage_code' => 'TU-DINH-KHO-01',
                'name' => 'Tủ định kho 01',
                'location' => 'Phòng lưu mẫu định kho',
                'description' => 'Tủ lưu mẫu cần điều kiện bảo quản riêng.',
            ],
            [
                'storage_code' => 'TU-DONG-LANH-01',
                'name' => 'Tủ đông lạnh 01',
                'location' => 'Phòng lưu mẫu sinh học',
                'description' => 'Tủ đông lạnh lưu mẫu sinh học.',
            ],
            [
                'storage_code' => 'TU-DIEN-TU-01',
                'name' => 'Tủ vật chứng điện tử',
                'location' => 'Phòng kỹ thuật số',
                'description' => 'Tủ lưu thiết bị điện tử, USB, ổ cứng, điện thoại.',
            ],
        ];

        foreach ($storages as $storage) {
            EvidenceStorage::updateOrCreate(
                ['storage_code' => $storage['storage_code']],
                $storage
            );
        }
    }
}
