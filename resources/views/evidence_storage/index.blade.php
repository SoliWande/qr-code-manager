<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="font-size:20px; font-weight:bold;">
                Quản lý kho vật chứng
            </h2>

            <a href="{{ route('evidence_storage.create') }}"
               style="background:#2563eb; color:white; padding:8px 14px; border-radius:8px; text-decoration:none;">
                Thêm kho
            </a>
        </div>
    </x-slot>

    <div style="padding:24px;">
        <div style="max-width:1200px; margin:auto;">

            @if (session('success'))
                <div style="background:#dcfce7; color:#166534; padding:12px; border-radius:8px; margin-bottom:16px;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="background:white; padding:20px; border-radius:12px;">
                <h3 style="font-size:18px; font-weight:bold; margin-bottom:16px;">
                    Danh sách kho / tủ / phòng lưu
                </h3>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                        <tr style="background:#f9fafb;">
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Mã kho</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Tên kho</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Vị trí</th>
                            <th style="text-align:right; padding:10px; border-bottom:1px solid #e5e7eb;">Tổng mẫu</th>
                            <th style="text-align:right; padding:10px; border-bottom:1px solid #e5e7eb;">Đang lưu kho</th>
                            <th style="text-align:right; padding:10px; border-bottom:1px solid #e5e7eb;">Đang giám định</th>
                            <th style="text-align:right; padding:10px; border-bottom:1px solid #e5e7eb;">Đã hoàn trả</th>
                            <th style="text-align:right; padding:10px; border-bottom:1px solid #e5e7eb;">Đã tiêu huỷ</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($storages as $storage)
                            <tr>
                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    <a href="{{ route('evidence_storage.show', $storage) }}"
                                       style="color:#2563eb; font-weight:bold;">
                                        {{ $storage->storage_code }}
                                    </a>
                                </td>

                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ $storage->name }}
                                </td>

                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ $storage->location ?? '-' }}
                                </td>

                                <td style="padding:10px; text-align:right; border-bottom:1px solid #e5e7eb;">
                                    {{ $storage->products_count }}
                                </td>

                                <td style="padding:10px; text-align:right; border-bottom:1px solid #e5e7eb;">
                                    {{ $storage->in_storage_count }}
                                </td>

                                <td style="padding:10px; text-align:right; border-bottom:1px solid #e5e7eb;">
                                    {{ $storage->assessment_count }}
                                </td>

                                <td style="padding:10px; text-align:right; border-bottom:1px solid #e5e7eb;">
                                    {{ $storage->returned_count }}
                                </td>

                                <td style="padding:10px; text-align:right; border-bottom:1px solid #e5e7eb;">
                                    {{ $storage->destroyed_count }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding:20px; text-align:center; color:#6b7280;">
                                    Chưa có kho vật chứng nào.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:16px;">
                    {{ $storages->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
