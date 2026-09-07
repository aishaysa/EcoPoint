<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('withdrawals')) {
            Schema::create('withdrawals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('package_id')->nullable()->constrained('withdraw_packages')->onDelete('set null');
                $table->integer('points');
                $table->decimal('amount', 12, 2);
                $table->string('payment_method');
                $table->string('account_number')->nullable();
                $table->string('account_name')->nullable();
                $table->string('bank_name')->nullable();
                $table->enum('status', ['pending', 'processing', 'success', 'failed'])->default('pending');
                $table->text('admin_note')->nullable();
                $table->timestamp('processed_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
};