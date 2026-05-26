<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Lịch sử quét QR</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            padding: 20px;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        th, td {
            border-bottom: 1px solid #e5e7eb;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f9fafb;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 999px;
            background: #e5e7eb;
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Lịch sử quét QR</h1>

    <table>
        <thead>
        <tr>
            <th>Thời gian</th>
            <th>Mã QR</th>
            <th>Sản phẩm</th>
            <th>Action</th>
            <th>SL</th>
            <th>Tồn trước</th>
            <th>Tồn sau</th>
            <th>Ghi chú</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($logs as $log)
            <tr>
                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                <td>{{ $log->qr_code }}</td>
                <td>{{ optional($log->product)->name ?? '-' }}</td>
                <td>
                    <span class="badge">{{ $log->action }}</span>
                </td>
                <td>{{ $log->quantity ?? '-' }}</td>
                <td>{{ $log->stock_before ?? '-' }}</td>
                <td>{{ $log->stock_after ?? '-' }}</td>
                <td>{{ $log->note ?? '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        {{ $logs->links() }}
    </div>
</div>

</body>
</html>
