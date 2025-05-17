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
        Schema::create('ayarlar', function (Blueprint $table) {
            $table->id();
            $table->string('site_adi')->nullable();
            $table->string('site_mail')->nullable();
            $table->boolean('bakim_modu')->default(false);
            $table->string('yetkili_ip')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('firma_adi')->nullable();
            $table->text('adres')->nullable();
            $table->string('telefon')->nullable();
            $table->string('vergi_no')->nullable();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ayarlar');
    }
};
