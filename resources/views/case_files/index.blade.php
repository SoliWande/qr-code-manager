<x-app-layout>
    <x-slot name="header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2 style="font-size:20px; font-weight:bold;">Quản lý hồ sơ</h2>

            <a href="{{ route('case_files.create') }}"
               style="background:#2563eb; color:white; padding:8px 14px; border-radius:8px; text-decoration:none;">
                Tạo hồ sơ
            </a>
        </div>
    </x-slot>

    <div style="padding:24px;">
        <div style="max-width:1100px; margin:auto; background:white; padding:20px; border-radius:12px;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                <tr>
                    <th style="text-align:left; padding:10px;">Mã hồ sơ</th>
                    <th style="text-align:left; padding:10px;">Tên hồ sơ</th>
                    <th style="text-align:left; padding:10px;">Hiện trường</th>
                    <th style="text-align:left; padding:10px;">Người phụ trách</th>
                    <th style="text-align:left; padding:10px;">Ngày lập</th>
                    <th style="text-align:left; padding:10px;">Trạng thái</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($caseFiles as $caseFile)
                    <tr>
                        <td style="padding:10px; border-top:1px solid #e5e7eb;">
                            <a href="{{ route('case_files.show', $caseFile) }}">
                                {{ $caseFile->case_code }}
                            </a>
                        </td>
                        <td style="padding:10px; border-top:1px solid #e5e7eb;">
                            {{ $caseFile->title }}
                        </td>
                        <td style="padding:10px; border-top:1px solid #e5e7eb;">
                            {{ $caseFile->scene_location }}
                        </td>
                        <td style="padding:10px; border-top:1px solid #e5e7eb;">
                            {{ $caseFile->officer_name }}
                        </td>
                        <td style="padding:10px; border-top:1px solid #e5e7eb;">
                            {{ $caseFile->case_date }}
                        </td>
                        <td style="padding:10px; border-top:1px solid #e5e7eb;">
                            {{ $caseFile->status }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div style="margin-top:16px;">
                {{ $caseFiles->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
