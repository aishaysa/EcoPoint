<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_sampahs', function (Blueprint $table) {
            $table->dropColumn('harga_per_kg');
        });
    }

    public function down(): void
    {
        Schema::table('jenis_sampahs', function (Blueprint $table) {
            $table->integer('harga_per_kg')->nullable();
        });
    }
};