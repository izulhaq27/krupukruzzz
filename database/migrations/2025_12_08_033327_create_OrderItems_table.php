<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PERBAIKAN: Gunakan snake_case dan huruf kecil: 'order_items'
        Schema::create('order_items', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('order_id');
    $table->unsignedBigInteger('product_id');
    $table->string('product_name')->default('');   // ← SUDAH AMAN
    $table->integer('quantity');
    $table->decimal('price', 12, 2);
    $table->timestamps();

    $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
    $table->foreign('product_id')->references('id')->on('products');
});
    }

    public function down(): void
    {
        // PERBAIKAN: Harus sama dengan nama tabel di atas
        Schema::dropIfExists('order_items');
    }
};