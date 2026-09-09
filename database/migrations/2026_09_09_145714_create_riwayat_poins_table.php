<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('riwayat_poins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('jenis'); // 'setoran', 'penarikan', 'refund'
            $table->text('deskripsi')->nullable();
            $table->integer('saldo_sebelumnya');
            $table->integer('saldo_setelah');
            $table->string('referensi_id')->nullable();
            $table->string('referensi_type')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('riwayat_poins');
    }
};