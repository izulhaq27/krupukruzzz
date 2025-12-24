<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
// ... (Bagian atas)

public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('order_number')->unique();
        $table->string('name')->nullable();
        $table->string('phone', 20)->nullable();
        $table->text('address')->nullable();
        
        // PERBAIKAN: Tambahkan default(0.00) agar kolom aman (NOT NULL dengan default)
        $table->decimal('total_amount', 15, 2)->default(0.00); 
        
        $table->string('snap_token')->nullable();
        $table->string('payment_type')->nullable();
        $table->string('transaction_id')->nullable();
        $table->enum('status', [
            'pending',
            'paid',
            'processed',
            'shipped',
            'completed',
            'cancelled',
            'failed'
        ])->default('pending');
        $table->timestamp('paid_at')->nullable();
        $table->timestamps();
    });
}

// ... (Bagian down tidak berubah)

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};