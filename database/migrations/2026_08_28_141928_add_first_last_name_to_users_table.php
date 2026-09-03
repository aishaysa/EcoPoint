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
    Schema::table('users', function (Blueprint $table) {
        // Hapus kolom name jika sebelumnya pakai string biasa, atau biarkan saja
        // Kita ubah name menjadi nullable dulu, lalu tambah first_name dan last_name
        $table->string('name')->nullable()->change(); 
        $table->string('first_name')->after('id');
        $table->string('last_name')->after('first_name');
        
        // Hapus kolom no_hp dan alamat (kalau sudah ada di tabel users)
        $table->dropColumn(['no_hp', 'alamat']); 
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('name')->nullable(false)->change();
        $table->dropColumn(['first_name', 'last_name']);
        $table->string('no_hp')->nullable();
        $table->text('alamat')->nullable();
    });
}};
