<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('setoran', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('pelanggan_id')->nullable()->constrained()->onDelete('set null');
    $table->string('nama_pengirim');
    $table->string('no_hp');
    $table->enum('metode', ['jemput', 'antar'])->default('jemput');
    $table->text('alamat_jemput')->nullable();
    $table->decimal('latitude', 10, 7)->nullable();
    $table->decimal('longitude', 10, 7)->nullable();
    $table->foreignId('titik_kumpul_id')->nullable()->constrained('titik_kumpul')->onDelete('set null');
    $table->enum('status', ['pending', 'approved', 'completed', 'rejected'])->default('pending');
    $table->decimal('berat_aktual', 8, 2)->default(0);
    $table->timestamps();
});

    }
};