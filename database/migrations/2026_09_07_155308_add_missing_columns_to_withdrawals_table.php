<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('withdrawals', 'payment_method')) {
                $table->string('payment_method')->after('amount');
            }
            if (!Schema::hasColumn('withdrawals', 'account_number')) {
                $table->string('account_number')->nullable()->after('payment_method');
            }
            if (!Schema::hasColumn('withdrawals', 'account_name')) {
                $table->string('account_name')->nullable()->after('account_number');
            }
            if (!Schema::hasColumn('withdrawals', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('account_name');
            }
            if (!Schema::hasColumn('withdrawals', 'admin_note')) {
                $table->text('admin_note')->nullable()->after('status');
            }
            if (!Schema::hasColumn('withdrawals', 'processed_at')) {
                $table->timestamp('processed_at')->nullable()->after('admin_note');
            }
        });
    }

    public function down()
    {
        Schema::table('withdrawals', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'account_number', 'account_name', 'bank_name', 'admin_note', 'processed_at']);
        });
    }
};