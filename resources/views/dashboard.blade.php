<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 20px; font-weight: bold;">
                Dashboard
            </h2>

            <a href="{{ route('products.scan') }}"
               style="background: #2563eb; color: white; padding: 8px 14px; border-radius: 8px; text-decoration: none;">
                Quét QR
            </a>
        </div>
    </x-slot>

    <div style="padding: 24px;">
        <div style="max-width: 1200px; margin: auto;">

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
                <div style="background: white; padding: 18px; border-radius: 12px;">
                    <div style="color: #6b7280; font-size: 14px;">Tổng sản phẩm</div>
                    <div style="font-size: 28px; font-weight: bold;">{{ $totalProducts }}</div>
                </div>

                <div style="background: white; padding: 18px; border-radius: 12px;">
                    <div style="color: #6b7280; font-size: 14px;">Lượt quét hôm nay</div>
                    <div style="font-size: 28px; font-weight: bold;">{{ $totalScansToday }}</div>
                </div>

                <div style="background: white; padding: 18px; border-radius: 12px;">
                    <div style="color: #6b7280; font-size: 14px;">Nhập kho hôm nay</div>
                    <div style="font-size: 28px; font-weight: bold;">{{ $totalImportToday }}</div>
                </div>

                <div style="background: white; padding: 18px; border-radius: 12px;">
                    <div style="color: #6b7280; font-size: 14px;">Xuất kho hôm nay</div>
                    <div style="font-size: 28px; font-weight: bold;">{{ $totalExportToday }}</div>
                </div>
            </div>

            <div style="background: white; padding: 20px; border-radius: 12px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
                    <h3 style="font-size: 18px; font-weight: bold; margin: 0;">
                        Lịch sử sử dụng sản phẩm gần nhất
                    </h3>

                    <a href="{{ route('scan_logs.index') }}" style="color: #2563eb;">
                        Xem tất cả
                    </a>
                </div>

                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                        <tr style="background: #f9fafb;">
                            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb;">Thời gian</th>
                            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb;">Mã QR</th>
                            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb;">Sản phẩm</th>
                            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb;">Thao tác</th>
                            <th style="padding: 10px; text-align: right; border-bottom: 1px solid #e5e7eb;">SL</th>
                            <th style="padding: 10px; text-align: right; border-bottom: 1px solid #e5e7eb;">Tồn trước</th>
                            <th style="padding: 10px; text-align: right; border-bottom: 1px solid #e5e7eb;">Tồn sau</th>
                            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb;">Người dùng</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($recentLogs as $log)
                            <tr>
                                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                </td>

                                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">
                                    {{ $log->qr_code }}
                                </td>

                                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">
                                    {{ optional($log->product)->name ?? '-' }}
                                </td>

                                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">
                                    @if ($log->action === 'view')
                                        <span style="background: #dbeafe; color: #1e40af; padding: 4px 8px; border-radius: 999px; font-size: 12px;">
                                                Xem
                                            </span>
                                    @elseif ($log->action === 'check_stock')
                                        <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 999px; font-size: 12px;">
                                                Kiểm kho
                                            </span>
                                    @elseif ($log->action === 'import_stock')
                                        <span style="background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 999px; font-size: 12px;">
                                                Nhập kho
                                            </span>
                                    @elseif ($log->action === 'export_stock')
                                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 999px; font-size: 12px;">
                                                Xuất kho
                                            </span>
                                    @else
                                        <span style="background: #e5e7eb; color: #374151; padding: 4px 8px; border-radius: 999px; font-size: 12px;">
                                                {{ $log->action }}
                                            </span>
                                    @endif
                                </td>

                                <td style="padding: 10px; text-align: right; border-bottom: 1px solid #e5e7eb;">
                                    {{ $log->quantity ?? '-' }}
                                </td>

                                <td style="padding: 10px; text-align: right; border-bottom: 1px solid #e5e7eb;">
                                    {{ $log->stock_before ?? '-' }}
                                </td>

                                <td style="padding: 10px; text-align: right; border-bottom: 1px solid #e5e7eb;">
                                    {{ $log->stock_after ?? '-' }}
                                </td>

                                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb;">
                                    {{ optional($log->user)->name ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding: 20px; text-align: center; color: #6b7280;">
                                    Chưa có lịch sử sử dụng sản phẩm.
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
