<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            
            // Tambah kolom alamat pengiriman
           $table->string('phone')->nullable();           // ✅ Tanpa after
           $table->text('address')->nullable();           // ✅ Tanpa after
           $table->string('city')->nullable();            // ✅ Tanpa after
           $table->string('province')->nullable();        // ✅ Tanpa after
           $table->string('postal_code')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};