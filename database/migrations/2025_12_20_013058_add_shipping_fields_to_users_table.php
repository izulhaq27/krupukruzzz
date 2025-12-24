<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'city')) {
                $table->string('city')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'province')) {
                $table->string('province')->nullable();
            }
            
            if (!Schema::hasColumn('users', 'postal_code')) {
                $table->string('postal_code')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Hanya drop kolom jika benar-benar ada
            $columnsToDrop = [];
            
            if (Schema::hasColumn('users', 'phone')) {
                $columnsToDrop[] = 'phone';
            }
            
            if (Schema::hasColumn('users', 'address')) {
                $columnsToDrop[] = 'address';
            }
            
            if (Schema::hasColumn('users', 'city')) {
                $columnsToDrop[] = 'city';
            }
            
            if (Schema::hasColumn('users', 'province')) {
                $columnsToDrop[] = 'province';
            }
            
            if (Schema::hasColumn('users', 'postal_code')) {
                $columnsToDrop[] = 'postal_code';
            }
            
            // Hanya drop jika ada kolom yang perlu di-drop
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
}