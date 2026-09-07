<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('withdraw_packages')) {
            Schema::create('withdraw_packages', function (Blueprint $table) {
                $table->id();
                $table->integer('points');
                $table->decimal('amount', 12, 2);
                $table->string('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('withdraw_packages');
    }
};