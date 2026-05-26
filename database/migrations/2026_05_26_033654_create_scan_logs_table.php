<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scan_logs', function (Blueprint $table) {
            $table->id();

            // Sản phẩm được quét
            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            // Nếu sau này có login nhân viên thì lưu user_id
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Mã QR thực tế đã quét
            $table->string('qr_code', 191);

            // view, import_stock, export_stock, check_stock
            $table->string('action', 50)->default('view');

            // Số lượng nhập/xuất, nếu có
            $table->integer('quantity')->nullable();

            // Tồn kho trước khi thao tác
            $table->integer('stock_before')->nullable();

            // Tồn kho sau khi thao tác
            $table->integer('stock_after')->nullable();

            // Ghi chú thêm
            $table->text('note')->nullable();

            // Thông tin thiết bị / IP, hữu ích cho audit nội bộ
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 500)->nullable();

            $table->timestamps();

            $table->index(['qr_code']);
            $table->index(['action']);
            $table->index(['created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scan_logs');
    }
};
