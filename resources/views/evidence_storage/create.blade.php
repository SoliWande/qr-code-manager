<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size:20px; font-weight:bold;">
            Thêm kho vật chứng
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

            <form method="POST" action="{{ route('evidence_storage.store') }}">
                @csrf

                <div style="margin-bottom:12px;">
                    <label>Mã kho</label>
                    <input type="text"
                           name="storage_code"
                           value="{{ old('storage_code') }}"
                           placeholder="Ví dụ: KHO-A, TU-DONG-01"
                           required
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Tên kho / tủ / phòng lưu</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="Ví dụ: Tủ định kho, Phòng lưu mẫu số 1"
                           required
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Vị trí</label>
                    <input type="text"
                           name="location"
                           value="{{ old('location') }}"
                           placeholder="Ví dụ: Tầng 2 - Phòng vật chứng"
                           style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
                </div>

                <div style="margin-bottom:12px;">
                    <label>Mô tả</label>
                    <textarea name="description"
                              rows="4"
                              style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">{{ old('description') }}</textarea>
                </div>

                <button type="submit"
                        style="background:#2563eb; color:white; padding:10px 16px; border:none; border-radius:8px;">
                    Lưu kho
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
