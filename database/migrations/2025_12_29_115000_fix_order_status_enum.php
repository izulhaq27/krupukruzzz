<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Adding 'delivered' to the enum. 
        // Note: Changing ENUM columns requires DB::statement in many cases if not using a dedicated package.
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'processed', 'shipped', 'delivered', 'completed', 'cancelled', 'failed') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'paid', 'processed', 'shipped', 'completed', 'cancelled', 'failed') NOT NULL DEFAULT 'pending'");
    }
};
