<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // HAPUS BARIS PERUBAHAN 'nama' KARENA KOLOM TERSEBUT TIDAK ADA

            // Tambahkan kolom first_name dan last_name
            // (Jika tabel users belum punya kolom sama sekali dan ingin menambahkan nama depan/belakang)
            $table->string('first_name')->nullable()->after('id');
            $table->string('last_name')->nullable()->after('first_name');

            // OPSIONAL: Jika Anda TETAP INGIN kolom 'nama' ada di tabel, tambahkan baris ini:
            // $table->string('nama')->nullable(); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name']);
        });
    }
};