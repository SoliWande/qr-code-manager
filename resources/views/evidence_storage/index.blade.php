<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="font-size:20px; font-weight:bold;">Quản lý kho vật chứng</h2>

            <a href="{{ route('products.scan') }}"
               style="background:#2563eb; color:white; padding:8px 14px; border-radius:8px; text-decoration:none;">
                Quét QR
            </a>
        </div>
    </x-slot>

    <div style="padding:24px;">
        <div style="max-width:1200px; margin:auto;">

            <div style="background:white; padding:20px; border-radius:12px; margin-bottom:20px;">
                <h3 style="font-size:18px; font-weight:bold; margin-bottom:12px;">Danh sách vật chứng trong hệ thống</h3>

                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                    <tr>
                        <th style="text-align:left; padding:10px;">Mã QR</th>
                        <th style="text-align:left; padding:10px;">Hồ sơ</th>
                        <th style="text-align:left; padding:10px;">Tên vật chứng</th>
                        <th style="text-align:left; padding:10px;">Vị trí</th>
                        <th style="text-align:left; padding:10px;">Trạng thái kho</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($evidences as $evidence)
                        <tr>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $evidence->qr_code }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ optional($evidence->caseFile)->case_code ?? '-' }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $evidence->name }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $evidence->location }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $evidence->storage_status ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div style="margin-top:16px;">
                    {{ $evidences->links() }}
                </div>
            </div>

            <div style="background:white; padding:20px; border-radius:12px;">
                <h3 style="font-size:18px; font-weight:bold; margin-bottom:12px;">Log lấy ra / lấy vào gần nhất</h3>

                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                    <tr>
                        <th style="text-align:left; padding:10px;">Thời gian</th>
                        <th style="text-align:left; padding:10px;">Mã QR</th>
                        <th style="text-align:left; padding:10px;">Hồ sơ</th>
                        <th style="text-align:left; padding:10px;">Vật chứng</th>
                        <th style="text-align:left; padding:10px;">Thao tác</th>
                        <th style="text-align:left; padding:10px;">Người dùng</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($recentLogs as $log)
                        <tr>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $log->qr_code }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ optional(optional($log->product)->caseFile)->case_code ?? '-' }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ optional($log->product)->name ?? '-' }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $log->action }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ optional($log->user)->name ?? '-' }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
