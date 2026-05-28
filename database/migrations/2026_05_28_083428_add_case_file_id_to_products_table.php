<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('case_file_id')
                ->nullable()
                ->after('id')
                ->constrained('case_files')
                ->nullOnDelete();

            $table->index('case_file_id');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['case_file_id']);
            $table->dropIndex(['case_file_id']);
            $table->dropColumn('case_file_id');
        });
    }
};
