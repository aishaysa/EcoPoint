<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('setoran_jenis_sampah', function (Blueprint $table) {
            $table->id();

            $table->foreignId('setoran_id')
                ->constrained('setoran')
                ->onDelete('cascade');

            $table->foreignId('jenis_sampah_id')
                ->constrained('jenis_sampahs')
                ->onDelete('cascade');

            $table->decimal('berat_estimasi', 8, 2)->default(0);
            $table->decimal('berat_aktual', 8, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setoran_jenis_sampah');
    }
};