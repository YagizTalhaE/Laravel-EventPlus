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
        Schema::table('ayarlar', function (Blueprint $table) {
            $table->text('hakkimda')->nullable()->after('adres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('ayarlar', function (Blueprint $table) {
            $table->dropColumn('hakkimda');
        });
    }
};
