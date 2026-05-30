<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="font-size:20px; font-weight:bold;">
                Kho {{ $evidenceStorage->storage_code }}
            </h2>

            <a href="{{ route('products.scan') }}"
               style="background:#2563eb; color:white; padding:8px 14px; border-radius:8px; text-decoration:none;">
                Quét QR
            </a>
        </div>
    </x-slot>

    <div style="padding:24px;">
        <div style="max-width:1200px; margin:auto;">

            <div style="background:white; padding:20px; border-radius:12px; margin-bottom:20px;">
                <h3 style="font-size:18px; font-weight:bold; margin-bottom:12px;">
                    Thông tin kho
                </h3>

                <p><strong>Mã kho:</strong> {{ $evidenceStorage->storage_code }}</p>
                <p><strong>Tên kho:</strong> {{ $evidenceStorage->name }}</p>
                <p><strong>Vị trí:</strong> {{ $evidenceStorage->location ?? '-' }}</p>
                <p><strong>Mô tả:</strong> {{ $evidenceStorage->description ?? '-' }}</p>
            </div>

            <div style="display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; margin-bottom:20px;">
                <div style="background:white; padding:16px; border-radius:12px;">
                    <div style="color:#6b7280;">Tổng mẫu</div>
                    <div style="font-size:28px; font-weight:bold;">{{ $evidenceStorage->products_count }}</div>
                </div>

                <div style="background:white; padding:16px; border-radius:12px;">
                    <div style="color:#6b7280;">Đang lưu kho</div>
                    <div style="font-size:28px; font-weight:bold;">{{ $evidenceStorage->in_storage_count }}</div>
                </div>

                <div style="background:white; padding:16px; border-radius:12px;">
                    <div style="color:#6b7280;">Đang giám định</div>
                    <div style="font-size:28px; font-weight:bold;">{{ $evidenceStorage->assessment_count }}</div>
                </div>

                <div style="background:white; padding:16px; border-radius:12px;">
                    <div style="color:#6b7280;">Đã xử lý</div>
                    <div style="font-size:28px; font-weight:bold;">
                        {{ $evidenceStorage->returned_count + $evidenceStorage->destroyed_count }}
                    </div>
                </div>
            </div>

            <div style="background:white; padding:20px; border-radius:12px; margin-bottom:20px;">
                <h3 style="font-size:18px; font-weight:bold; margin-bottom:16px;">
                    Mẫu vật chứng trong kho này
                </h3>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                        <tr style="background:#f9fafb;">
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Mã QR</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Hồ sơ</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Tên vật chứng</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Loại</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Vị trí cụ thể</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Trạng thái</th>
                            <th style="text-align:left; padding:10px; border-bottom:1px solid #e5e7eb;">Cập nhật</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ $product->qr_code }}
                                </td>

                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ optional($product->caseFile)->case_code ?? '-' }}
                                </td>

                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ $product->name }}
                                </td>

                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ $product->type_name }}
                                </td>

                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ $product->location ?? '-' }}
                                </td>

                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ $product->storage_status_name }}
                                </td>

                                <td style="padding:10px; border-bottom:1px solid #e5e7eb;">
                                    {{ $product->updated_at?->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding:20px; text-align:center; color:#6b7280;">
                                    Kho này chưa có mẫu vật chứng nào.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div style="margin-top:16px;">
                    {{ $products->links() }}
                </div>
            </div>

            <div style="background:white; padding:20px; border-radius:12px;">
                <h3 style="font-size:18px; font-weight:bold; margin-bottom:16px;">
                    Log thao tác gần nhất trong kho này
                </h3>

                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                        <tr style="background:#f9fafb;">
                            <th style="text-align:left; padding:10px;">Thời gian</th>
                            <th style="text-align:left; padding:10px;">Mã QR</th>
                            <th style="text-align:left; padding:10px;">Vật chứng</th>
                            <th style="text-align:left; padding:10px;">Thao tác</th>
                            <th style="text-align:left; padding:10px;">Người dùng</th>
                            <th style="text-align:left; padding:10px;">Ghi chú</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($recentLogs as $log)
                            <tr>
                                <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                </td>

                                <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                    {{ $log->qr_code }}
                                </td>

                                <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                    {{ optional($log->product)->name ?? '-' }}
                                </td>

                                <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                    {{ \App\Models\ScanLog::ACTION_LABELS[$log->action] ?? $log->action }}
                                </td>

                                <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                    {{ optional($log->user)->name ?? '-' }}
                                </td>

                                <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                    {{ $log->note ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding:20px; text-align:center; color:#6b7280;">
                                    Chưa có log thao tác cho kho này.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
