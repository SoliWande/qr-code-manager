<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ScanLog;
use App\Models\User;
use Illuminate\Database\Seeder;

class ScanLogSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', User::ROLE_ADMIN)->first();
        $sceneOfficer = User::where('role', User::ROLE_SCENE_OFFICER)->first();
        $storageKeeper = User::where('role', User::ROLE_STORAGE_KEEPER)->first();
        $labTechnician = User::where('role', User::ROLE_LAB_TECHNICIAN)->first();
        $commander = User::where('role', User::ROLE_COMMANDER)->first();

        $defaultUser = User::first();

        $logs = [
            [
                'qr_code' => 'HS0001-VC001',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Nhập kho ban đầu | Vị trí lưu trữ: Tủ vật chứng A - Ngăn 01',
                'created_at' => now()->subDays(5)->addHours(1),
            ],
            [
                'qr_code' => 'HS0001-VC002',
                'user_id' => optional($sceneOfficer ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_VIEW,
                'note' => 'Xem thông tin biên bản hiện trường',
                'created_at' => now()->subDays(5)->addHours(2),
            ],
            [
                'qr_code' => 'HS0001-VC003',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Nhập kho dữ liệu ảnh hiện trường',
                'created_at' => now()->subDays(4)->addHours(1),
            ],
            [
                'qr_code' => 'HS0001-VC004',
                'user_id' => optional($commander ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_HANDOVER_ASSESSMENT,
                'note' => 'Người nhận: Phòng giám định dấu vết',
                'created_at' => now()->subDays(4)->addHours(3),
            ],
            [
                'qr_code' => 'HS0001-VC005',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Nhập kho thiết bị lưu trữ điện tử',
                'created_at' => now()->subDays(4)->addHours(4),
            ],

            [
                'qr_code' => 'HS0002-VC001',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Vị trí lưu trữ: Tủ định kho - Ngăn 01',
                'created_at' => now()->subDays(3)->addHours(1),
            ],
            [
                'qr_code' => 'HS0002-VC002',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Nhập kho hộp carton nhỏ',
                'created_at' => now()->subDays(3)->addHours(2),
            ],
            [
                'qr_code' => 'HS0002-VC003',
                'user_id' => optional($commander ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_RETURN_DESTROY,
                'note' => 'Hình thức: Hoàn trả | Hoàn trả phiếu xuất kho cho đơn vị điều tra',
                'created_at' => now()->subDays(3)->addHours(4),
            ],
            [
                'qr_code' => 'HS0002-VC004',
                'user_id' => optional($commander ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_HANDOVER_ASSESSMENT,
                'note' => 'Người nhận: Kỹ thuật viên giám định dữ liệu',
                'created_at' => now()->subDays(2)->addHours(1),
            ],
            [
                'qr_code' => 'HS0002-VC005',
                'user_id' => optional($labTechnician ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_VIEW,
                'note' => 'Kiểm tra ảnh camera kho hàng',
                'created_at' => now()->subDays(2)->addHours(2),
            ],
            [
                'qr_code' => 'HS0002-VC006',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Nhập kho tem niêm phong bị rách',
                'created_at' => now()->subDays(2)->addHours(3),
            ],
            [
                'qr_code' => 'HS0002-VC007',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Nhập kho mẫu bụi thu trên sàn',
                'created_at' => now()->subDays(2)->addHours(4),
            ],

            [
                'qr_code' => 'HS0003-VC001',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Nhập kho ly thủy tinh',
                'created_at' => now()->subDay()->addHour(),
            ],
            [
                'qr_code' => 'HS0003-VC002',
                'user_id' => optional($commander ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_HANDOVER_ASSESSMENT,
                'note' => 'Người nhận: Phòng giám định điện tử',
                'created_at' => now()->subDay()->addHours(2),
            ],
            [
                'qr_code' => 'HS0003-VC003',
                'user_id' => optional($sceneOfficer ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_VIEW,
                'note' => 'Xem thông tin sổ tay cá nhân',
                'created_at' => now()->subDay()->addHours(3),
            ],
            [
                'qr_code' => 'HS0003-VC004',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Nhập kho thẻ nhớ microSD',
                'created_at' => now()->subHours(20),
            ],
            [
                'qr_code' => 'HS0003-VC005',
                'user_id' => optional($commander ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_RETURN_DESTROY,
                'note' => 'Hình thức: Hoàn trả | Hoàn trả áo khoác theo quyết định',
                'created_at' => now()->subHours(18),
            ],
            [
                'qr_code' => 'HS0003-VC006',
                'user_id' => optional($labTechnician ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_VIEW,
                'note' => 'Xem bộ ảnh chụp căn hộ',
                'created_at' => now()->subHours(12),
            ],
            [
                'qr_code' => 'HS0003-VC007',
                'user_id' => optional($commander ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_RETURN_DESTROY,
                'note' => 'Hình thức: Tiêu huỷ | Mẫu tóc đã tiêu huỷ theo biên bản',
                'created_at' => now()->subHours(8),
            ],
            [
                'qr_code' => 'HS0003-VC008',
                'user_id' => optional($storageKeeper ?? $defaultUser)->id,
                'action' => ScanLog::ACTION_IMPORT_STORAGE,
                'note' => 'Nhập kho chùm chìa khóa kim loại',
                'created_at' => now()->subHours(2),
            ],
        ];

        foreach ($logs as $log) {
            $product = Product::where('qr_code', $log['qr_code'])->first();

            ScanLog::create([
                'product_id' => optional($product)->id,
                'user_id' => $log['user_id'],
                'qr_code' => $log['qr_code'],
                'action' => $log['action'],
                'quantity' => 1,
                'stock_before' => null,
                'stock_after' => optional($product)->stock,
                'note' => $log['note'],
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Seeder',
                'created_at' => $log['created_at'],
                'updated_at' => $log['created_at'],
            ]);
        }
    }
}
