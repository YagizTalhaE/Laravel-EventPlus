<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('etkinlik_yönetimis', function (Blueprint $table) {
            $table->dropColumn('kontenjan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('etkinlik_yönetimis', function (Blueprint $table) {
            $table->integer('kontenjan')->default(0);
        });
    }
};
