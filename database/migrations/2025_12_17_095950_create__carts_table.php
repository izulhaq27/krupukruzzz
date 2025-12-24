<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Cek apakah tabel carts sudah ada
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                // 1. Drop unique constraint dulu (cek apakah ada)
                if (Schema::hasColumn('carts', 'session_id') && Schema::hasColumn('carts', 'product_id')) {
                    try {
                        $table->dropUnique(['session_id', 'product_id']);
                    } catch (\Exception $e) {
                        // Index mungkin tidak ada, skip
                    }
                }
                
                // 2. Ubah session_id jadi nullable (cek apakah kolom ada)
                if (Schema::hasColumn('carts', 'session_id')) {
                    $table->string('session_id')->nullable()->change();
                }
                
                // 3. Tambah user_id (cek apakah belum ada)
                if (!Schema::hasColumn('carts', 'user_id')) {
                    $table->foreignId('user_id')
                          ->nullable()
                          ->after('id')
                          ->constrained()
                          ->cascadeOnDelete();
                }
                
                // 4. Tambah index baru (cek apakah belum ada)
                if (Schema::hasColumn('carts', 'user_id') && Schema::hasColumn('carts', 'product_id')) {
                    try {
                        $table->index(['user_id', 'product_id']);
                    } catch (\Exception $e) {
                        // Index mungkin sudah ada, skip
                    }
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('carts')) {
            Schema::table('carts', function (Blueprint $table) {
                // Rollback dalam urutan terbalik
                try {
                    $table->dropIndex(['user_id', 'product_id']);
                } catch (\Exception $e) {}
                
                if (Schema::hasColumn('carts', 'user_id')) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                }
                
                if (Schema::hasColumn('carts', 'session_id')) {
                    $table->string('session_id')->nullable(false)->change();
                    
                    try {
                        $table->unique(['session_id', 'product_id']);
                    } catch (\Exception $e) {}
                }
            });
        }
    }
};