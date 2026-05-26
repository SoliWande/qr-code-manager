<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách QR sản phẩm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            padding: 20px;
        }

        .page {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        button {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .qr-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 14px;
            text-align: center;
            page-break-inside: avoid;
        }

        .qr-code {
            margin-bottom: 8px;
        }

        .product-code {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 4px;
        }

        .product-name {
            font-size: 13px;
            color: #374151;
            min-height: 36px;
        }

        .sku {
            margin-top: 4px;
            font-size: 12px;
            color: #6b7280;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .header {
                display: none;
            }

            .page {
                max-width: none;
            }

            .grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 10px;
            }

            .qr-card {
                border: 1px solid #000;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>

<div class="page">
    <div class="header">
        <h1>Danh sách QR sản phẩm</h1>

        <button onclick="window.print()">
            In QR
        </button>
    </div>

    <div class="grid">
        @foreach ($products as $product)
            <div class="qr-card">
                <div class="qr-code">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(130)->generate($product->qr_code) !!}
                </div>

                <div class="product-code">
                    {{ $product->qr_code }}
                </div>

                <div class="product-name">
                    {{ $product->name }}
                </div>

                <div class="sku">
                    {{ $product->sku }}
                </div>
            </div>
        @endforeach
    </div>
</div>

</body>
</html>
