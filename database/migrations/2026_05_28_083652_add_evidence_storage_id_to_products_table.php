<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('evidence_storage_id')
                ->nullable()
                ->after('case_file_id')
                ->constrained('evidence_storages')
                ->nullOnDelete();

            $table->string('storage_status', 50)
                ->default('in_storage')
                ->after('evidence_storage_id');

            $table->index('storage_status');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['evidence_storage_id']);
            $table->dropColumn('evidence_storage_id');
            $table->dropColumn('storage_status');
        });
    }
};
