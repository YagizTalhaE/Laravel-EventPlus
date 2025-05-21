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
        Schema::table('etkinlik_yönetimis', function (Blueprint $table) {
            $table->integer('kontenjan')->default(0);
            $table->decimal('bilet_fiyati', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etkinlik_yönetimis', function (Blueprint $table) {
            $table->dropColumn(['kontenjan', 'bilet_fiyati']);
        });
    }
};
