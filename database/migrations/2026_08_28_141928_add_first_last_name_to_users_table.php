<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up()
{
    Schema::table('users', function (Blueprint $table) {
        // Cek apakah kolom first_name sudah ada, jika belum baru tambah
        if (!Schema::hasColumn('users', 'first_name')) {
            $table->string('first_name')->after('id');
        }
        if (!Schema::hasColumn('users', 'last_name')) {
            $table->string('last_name')->nullable()->after('first_name');
        }
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
