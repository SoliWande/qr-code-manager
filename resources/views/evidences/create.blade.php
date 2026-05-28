<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:20px; font-weight:bold;">
            Thêm vật chứng cho hồ sơ {{ $caseFile->case_code }}
        </h2>
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

            <form method="POST" action="{{ route('evidences.store', $caseFile) }}">
                @csrf

                <div style="margin-bottom:12px;">
                    <label>Tên mẫu vật chứng</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Loại vật chứng</label>
                    <select name="type" required
                            style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                        @foreach (\App\Models\Product::TYPES as $value => $label)
                            <option value="{{ $value }}" @selected(old('type') == $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="margin-bottom:12px;">
                    <label>Mã phụ / ký hiệu</label>
                    <input type="text" name="sku" value="{{ old('sku') }}"
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Vị trí lưu kho ban đầu</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Mô tả mẫu vật chứng</label>
                    <textarea name="description" rows="4"
                              style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">{{ old('description') }}</textarea>
                </div>

                <button type="submit"
                        style="background:#2563eb; color:white; padding:10px 16px; border:none; border-radius:8px;">
                    Lưu vật chứng
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
