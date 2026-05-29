<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="font-size:20px; font-weight:bold;">
                Hồ sơ {{ $caseFile->case_code }}
            </h2>

            <a href="{{ route('evidences.create', $caseFile) }}"
               style="background:#2563eb; color:white; padding:8px 14px; border-radius:8px; text-decoration:none;">
                Thêm vật chứng
            </a>
        </div>
    </x-slot>

    <style>
        @media (max-width: 768px) {
            .case-info-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>

    <div style="padding:24px;">
        <div style="max-width:1100px; margin:auto;">

            <div style="background:white; padding:20px; border-radius:12px; margin-bottom:20px;">
                <div class="case-info-grid" style="display:grid; grid-template-columns: 1fr 180px; gap:20px; align-items:start;">

                    <div>
                        <h3 style="font-size:18px; font-weight:bold; margin-bottom:12px;">
                            Thông tin hồ sơ
                        </h3>

                        <p><strong>Mã hồ sơ:</strong> {{ $caseFile->case_code }}</p>
                        <p><strong>Tên hồ sơ:</strong> {{ $caseFile->title }}</p>
                        <p><strong>Địa điểm hiện trường:</strong> {{ $caseFile->scene_location }}</p>
                        <p>
                            <strong>Người phụ trách:</strong>
                            {{ optional($caseFile->officer)->name ?? $caseFile->officer_name ?? '-' }}
                        </p>
                        <p><strong>Ngày lập:</strong> {{ $caseFile->case_date }}</p>
                        <p><strong>Mô tả:</strong> {{ $caseFile->description }}</p>
                    </div>

                    <div style="text-align:center;">
                        <div style="font-weight:bold; margin-bottom:8px;">
                            QR hồ sơ
                        </div>

                        <div style="background:white; display:inline-block; padding:8px; border:1px solid #e5e7eb;">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(140)->margin(2)->generate($caseFile->case_code) !!}
                        </div>

                        <div style="margin-top:8px; font-size:13px; color:#374151;">
                            {{ $caseFile->case_code }}
                        </div>

                        <button type="button"
                                onclick="window.print()"
                                style="margin-top:10px; background:#2563eb; color:white; padding:8px 12px; border:none; border-radius:8px;">
                            In QR
                        </button>
                    </div>

                </div>
            </div>

            <div style="background:white; padding:20px; border-radius:12px;">
                <h3 style="font-size:18px; font-weight:bold; margin-bottom:12px;">Danh sách mẫu vật chứng</h3>

                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                    <tr>
                        <th style="text-align:left; padding:10px;">Mã QR</th>
                        <th style="text-align:left; padding:10px;">Tên vật chứng</th>
                        <th style="text-align:left; padding:10px;">Loại</th>
                        <th style="text-align:left; padding:10px;">SKU/Mã phụ</th>
                        <th style="text-align:left; padding:10px;">Vị trí</th>
                        <th style="text-align:left; padding:10px;">Trạng thái kho</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse ($caseFile->products as $product)
                        <tr>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $product->qr_code }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $product->name }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $product->type_name }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $product->sku }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $product->location }}
                            </td>
                            <td style="padding:10px; border-top:1px solid #e5e7eb;">
                                {{ $product->storage_status ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding:20px; text-align:center; color:#6b7280;">
                                Chưa có mẫu vật chứng nào.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
