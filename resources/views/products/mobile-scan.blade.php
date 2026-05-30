<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quét QR sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }

        .app {
            max-width: 520px;
            margin: 0 auto;
            min-height: 100vh;
            background: #ffffff;
        }

        .header {
            padding: 16px;
            background: #111827;
            color: #ffffff;
            text-align: center;
        }

        .header h1 {
            font-size: 20px;
            margin: 0;
        }

        .content {
            padding: 16px;
        }

        #reader {
            width: 100%;
            overflow: hidden;
            border-radius: 12px;
            background: #000;
        }

        .btn-row {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        button {
            flex: 1;
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-danger {
            background: #dc2626;
            color: #ffffff;
        }

        .manual-box {
            margin-top: 16px;
        }

        input, textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
        }

        textarea {
            resize: vertical;
        }

        .message {
            margin-top: 12px;
            padding: 10px;
            border-radius: 8px;
            display: none;
            font-size: 14px;
        }

        .message.success {
            display: block;
            background: #dcfce7;
            color: #166534;
        }

        .message.error {
            display: block;
            background: #fee2e2;
            color: #991b1b;
        }

        .product-card {
            margin-top: 16px;
            padding: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #f9fafb;
        }

        .field {
            margin-bottom: 12px;
        }

        .field label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 4px;
            color: #374151;
        }

        .hint {
            margin-top: 10px;
            font-size: 13px;
            color: #6b7280;
            line-height: 1.5;
        }

        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="app">
    <div class="header">
        <h1>Quét QR sản phẩm</h1>
    </div>

    <div class="content">
        <div id="reader"></div>

        <div class="field">
            <label>Thao tác sau khi quét</label>
            <select id="action" onchange="toggleActionFields()">
                <option value="view">Chỉ xem thông tin</option>
                <option value="import_storage">Nhập kho vật chứng</option>
                <option value="handover_assessment">Xuất bàn giao giám định</option>
                <option value="return_destroy">Hoàn trả / Tiêu huỷ</option>
            </select>
        </div>

        <div id="import_storage_fields" style="display:none;">
            <div class="field">
                <label>Kho / tủ / phòng lưu</label>

                <select id="evidence_storage_id">
                    <option value="">-- Chọn kho lưu trữ --</option>

                    @foreach ($storages as $storage)
                        <option value="{{ $storage->id }}">
                            {{ $storage->storage_code }} - {{ $storage->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label>Vị trí cụ thể</label>
                <input
                    type="text"
                    id="storage_location"
                    placeholder="Ví dụ: Ngăn 01, kệ số 2, hộp mẫu A"
                >
            </div>
        </div>

        <div id="handover_assessment_fields" style="display:none;">
            <div class="field">
                <label>Người nhận giám định</label>
                <input
                    type="text"
                    id="receiver_name"
                    placeholder="Tên cán bộ/phòng Hóa/Sinh tiếp nhận"
                >
            </div>
        </div>

        <div id="return_destroy_fields" style="display:none;">
            <div class="field">
                <label>Hình thức xử lý</label>
                <select id="return_type">
                    <option value="return">Hoàn trả cơ quan điều tra</option>
                    <option value="destroy">Tiêu huỷ</option>
                </select>
            </div>
        </div>

        <div class="field">
            <label>Ghi chú</label>
            <input type="text" id="note" placeholder="Ghi chú nếu có">
        </div>

        <div class="btn-row">
            <button type="button" class="btn-primary" onclick="startScanner()">
                Bật camera
            </button>

            <button type="button" class="btn-danger" onclick="stopScanner()">
                Tắt
            </button>
        </div>

        <div class="manual-box">
            <input
                type="text"
                id="manual_qr"
                placeholder="Hoặc nhập mã QR, ví dụ PRD001"
            >
            <div class="hint">
                Trên mobile nên dùng camera sau. Nếu camera không bật, hãy kiểm tra HTTPS/quyền camera của trình duyệt.
            </div>
        </div>

        <div id="message" class="message"></div>

        <div class="product-card">
            <div class="field">
                <label>Mã QR</label>
                <input type="text" id="qr_code" readonly>
            </div>

            <div class="field">
                <label>Tên sản phẩm</label>
                <input type="text" id="name" readonly>
            </div>

            <div class="field">
                <label>SKU</label>
                <input type="text" id="sku" readonly>
            </div>

            <div class="field">
                <label>Loại vật chứng</label>
                <input type="text" id="type" readonly>
            </div>

            <div class="field">
                <label>Trạng thái kho</label>
                <input type="text" id="storage_status" readonly>
            </div>

            <div class="field">
                <label>Vị trí kho</label>
                <input type="text" id="location" readonly>
            </div>

            <div class="field">
                <label>Mô tả</label>
                <textarea id="description" rows="3" readonly></textarea>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    let scanner = null;
    let isScanning = false;
    let lastCode = null;
    let lastScanAt = 0;

    function showMessage(text, type) {
        const el = document.getElementById('message');
        el.innerText = text;
        el.className = 'message ' + type;
    }

    function clearForm() {
        document.getElementById('qr_code').value = '';
        document.getElementById('name').value = '';
        document.getElementById('sku').value = '';
        document.getElementById('type').value = '';
        document.getElementById('storage_status').value = '';
        document.getElementById('location').value = '';
        document.getElementById('description').value = '';
    }

    function fillForm(product) {
        document.getElementById('qr_code').value = product.qr_code ?? '';
        document.getElementById('name').value = product.name ?? '';
        document.getElementById('sku').value = product.sku ?? '';
        document.getElementById('type').value = product.type_name ?? '';
        document.getElementById('storage_status').value = product.storage_status_name ?? '';
        document.getElementById('location').value = product.location ?? '';
        document.getElementById('description').value = product.description ?? '';
    }

    function toggleActionFields() {
        const action = document.getElementById('action').value;

        document.getElementById('import_storage_fields').style.display = 'none';
        document.getElementById('handover_assessment_fields').style.display = 'none';
        document.getElementById('return_destroy_fields').style.display = 'none';

        if (action === 'import_storage') {
            document.getElementById('import_storage_fields').style.display = 'block';
        }

        if (action === 'handover_assessment') {
            document.getElementById('handover_assessment_fields').style.display = 'block';
        }

        if (action === 'return_destroy') {
            document.getElementById('return_destroy_fields').style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        toggleActionFields();
    });

    async function findProduct(code) {
        code = code.trim();

        if (!code) {
            return;
        }

        const now = Date.now();

        if (code === lastCode && now - lastScanAt < 1500) {
            return;
        }

        lastCode = code;
        lastScanAt = now;

        const action = document.getElementById('action').value;
        const storageLocation = document.getElementById('storage_location')?.value || '';
        const receiverName = document.getElementById('receiver_name')?.value || '';
        const returnType = document.getElementById('return_type')?.value || '';
        const note = document.getElementById('note')?.value || '';
        const evidenceStorageId = document.getElementById('evidence_storage_id')?.value || '';

        const params = new URLSearchParams();

        params.append('action', action);

        if (storageLocation) {
            params.append('storage_location', storageLocation);
        }

        if (receiverName) {
            params.append('receiver_name', receiverName);
        }

        if (returnType) {
            params.append('return_type', returnType);
        }

        if (note) {
            params.append('note', note);
        }

        if (evidenceStorageId) {
            params.append('evidence_storage_id', evidenceStorageId);
        }

        try {
            const response = await fetch(
                '/api/products/qr/' + encodeURIComponent(code) + '?' + params.toString(),
                {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            );

            const contentType = response.headers.get('content-type') || '';

            let data;

            if (contentType.includes('application/json')) {
                data = await response.json();
            } else {
                const text = await response.text();
                console.log('Non JSON response:', text);

                throw new Error('Server không trả về JSON. Có thể bạn chưa đăng nhập hoặc không có quyền thao tác.');
            }

            console.log('API response:', data);

            if (!response.ok) {
                throw new Error(data.message || 'Có lỗi xảy ra');
            }

            fillForm(data.product);

            if (action === 'import_storage') {
                showMessage('Đã nhập kho vật chứng: ' + data.product.name, 'success');
            } else if (action === 'handover_assessment') {
                showMessage('Đã bàn giao giám định: ' + data.product.name, 'success');
            } else if (action === 'return_destroy') {
                showMessage('Đã ghi nhận hoàn trả/tiêu huỷ: ' + data.product.name, 'success');
            } else {
                showMessage('Đã tìm thấy mẫu vật chứng: ' + data.product.name, 'success');
            }

        } catch (error) {
            clearForm();
            document.getElementById('qr_code').value = code;
            showMessage(error.message, 'error');
        }
    }

    async function startScanner() {
        if (isScanning) {
            return;
        }

        if (!scanner) {
            scanner = new Html5Qrcode("reader", {
                formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ],
                verbose: true
            });
        }

        try {
            await scanner.start(
                {
                    facingMode: "environment"
                },
                {
                    fps: 15,
                    qrbox: function(viewfinderWidth, viewfinderHeight) {
                        const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                        const qrboxSize = Math.floor(minEdge * 0.75);

                        return {
                            width: qrboxSize,
                            height: qrboxSize
                        };
                    },
                    aspectRatio: 1.777778
                },
                decodedText => {
                    console.log('QR detected:', decodedText);
                    showMessage('Đã đọc QR: ' + decodedText, 'success');
                    findProduct(decodedText);
                },
                errorMessage => {
                    // Không cần show liên tục vì mỗi frame không đọc được sẽ bắn lỗi
                    console.log('Scan frame error:', errorMessage);
                }
            );

            isScanning = true;
            showMessage('Camera đã bật. Hãy đưa QR vào khung quét.', 'success');

        } catch (error) {
            showMessage('Không mở được camera. Hãy kiểm tra quyền camera hoặc HTTPS.', 'error');
        }
    }

    async function stopScanner() {
        if (!scanner || !isScanning) {
            return;
        }

        await scanner.stop();
        isScanning = false;
        showMessage('Đã tắt camera.', 'success');
    }

    document.getElementById('manual_qr').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') {
            findProduct(this.value);
            this.value = '';
        }
    });
</script>

</body>
</html>
