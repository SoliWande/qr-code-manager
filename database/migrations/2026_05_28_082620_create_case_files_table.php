<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_files', function (Blueprint $table) {
            $table->id();

            // Mã hồ sơ tự sinh: HS0001, HS0002...
            $table->string('case_code', 191)->unique();

            // Tên hồ sơ/vụ việc
            $table->string('title');

            // Thông tin hiện trường
            $table->string('scene_location')->nullable();

            // Người phụ trách
            $table->string('officer_name')->nullable();

            // Ngày lập hồ sơ
            $table->date('case_date')->nullable();

            // Mô tả
            $table->text('description')->nullable();

            // Trạng thái hồ sơ
            $table->string('status', 50)->default('open');

            $table->timestamps();

            $table->index('case_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_files');
    }
};
