<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:20px; font-weight:bold;">Tạo hồ sơ mới</h2>
    </x-slot>

    <div style="padding:24px;">
        <div style="max-width:700px; margin:auto; background:white; padding:20px; border-radius:12px;">

            @if ($errors->any())
                <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:16px;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('case_files.store') }}">
                @csrf

                <div style="margin-bottom:12px;">
                    <label>Tên hồ sơ / vụ việc</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Địa điểm hiện trường</label>
                    <input type="text" name="scene_location" value="{{ old('scene_location') }}"
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Người phụ trách</label>
                    <input type="text" name="officer_name" value="{{ old('officer_name') }}"
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Ngày lập hồ sơ</label>
                    <input type="date" name="case_date" value="{{ old('case_date') }}"
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Mô tả</label>
                    <textarea name="description" rows="4"
                              style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">{{ old('description') }}</textarea>
                </div>

                <button type="submit"
                        style="background:#2563eb; color:white; padding:10px 16px; border:none; border-radius:8px;">
                    Lưu hồ sơ
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
