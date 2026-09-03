<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('titik_kumpul')
            ->whereNull('is_active')
            ->update(['is_active' => 1]);
    }

    public function down(): void
    {
        //
    }
};