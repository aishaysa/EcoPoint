<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('exchange_packages', function (Blueprint $table) {
        $table->id();
        $table->integer('points');
        $table->integer('amount'); // dalam Rupiah
        $table->string('description')->nullable(); // misal "Paket 50 Poin"
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('exchange_packages');
}
};
