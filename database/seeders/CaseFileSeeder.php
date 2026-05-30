<?php

namespace Database\Seeders;

use App\Models\CaseFile;
use App\Models\User;
use Illuminate\Database\Seeder;

class CaseFileSeeder extends Seeder
{
    public function run(): void
    {
        $officer = User::where('role', User::ROLE_SCENE_OFFICER)->first()
            ?? User::first();

        $caseFiles = [
            [
                'case_code' => 'HS0001',
                'title' => 'Hồ sơ vụ án tại hiện trường A',
                'scene_location' => 'Hiện trường số 12, phường Minh Khai',
                'case_date' => now()->subDays(5)->toDateString(),
                'description' => 'Hồ sơ khám nghiệm hiện trường ban đầu.',
                'status' => 'open',
            ],
            [
                'case_code' => 'HS0002',
                'title' => 'Hồ sơ vụ việc tại kho hàng B',
                'scene_location' => 'Kho hàng B, khu công nghiệp số 3',
                'case_date' => now()->subDays(3)->toDateString(),
                'description' => 'Hồ sơ thu giữ mẫu vật chứng tại kho hàng.',
                'status' => 'open',
            ],
            [
                'case_code' => 'HS0003',
                'title' => 'Hồ sơ vụ án tại căn hộ C',
                'scene_location' => 'Căn hộ C1205, toà nhà trung tâm',
                'case_date' => now()->subDay()->toDateString(),
                'description' => 'Hồ sơ vật chứng thu tại căn hộ.',
                'status' => 'open',
            ],
        ];

        foreach ($caseFiles as $caseFile) {
            CaseFile::updateOrCreate(
                ['case_code' => $caseFile['case_code']],
                array_merge($caseFile, [
                    'officer_user_id' => optional($officer)->id,
                    'officer_name' => optional($officer)->name,
                ])
            );
        }
    }
}
