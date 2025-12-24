<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kolom yang sudah ada:
            // id, user_id, order_number, name, phone, address, 
            // total_amount, snap_token, payment_type, transaction_id, 
            // status, paid_at, created_at, updated_at
            
            // TAMBAH KOLOM BARU SETELAH 'updated_at' atau di akhir
            
            // 1. shipping_courier - kurir pengiriman
            if (!Schema::hasColumn('orders', 'shipping_courier')) {
                $table->string('shipping_courier')->nullable()->after('updated_at');
            }
            
            // 2. shipping_service - layanan pengiriman
            if (!Schema::hasColumn('orders', 'shipping_service')) {
                $table->string('shipping_service')->nullable()->after('shipping_courier');
            }
            
            // 3. shipping_cost - biaya pengiriman
            if (!Schema::hasColumn('orders', 'shipping_cost')) {
                $table->decimal('shipping_cost', 10, 2)->default(0)->after('shipping_service');
            }
            
            // 4. tracking_number - nomor resi
            if (!Schema::hasColumn('orders', 'tracking_number')) {
                $table->string('tracking_number')->nullable()->after('shipping_cost');
            }
            
            // 5. shipped_at - tanggal dikirim
            if (!Schema::hasColumn('orders', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('tracking_number');
            }
            
            // 6. estimated_delivery - estimasi tiba
            if (!Schema::hasColumn('orders', 'estimated_delivery')) {
                $table->date('estimated_delivery')->nullable()->after('shipped_at');
            }
            
            // 7. notes - catatan pesanan (opsional)
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('estimated_delivery');
            }
            
            // KOLOM 'payment_method' SUDAH ADA SEBAGAI 'payment_type'
            // Tidak perlu tambah lagi
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Hapus kolom yang kita tambah
            $columns = [
                'shipping_courier',
                'shipping_service', 
                'shipping_cost',
                'tracking_number',
                'shipped_at',
                'estimated_delivery',
                'notes'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};