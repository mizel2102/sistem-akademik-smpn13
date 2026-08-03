<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('warning_letters', function (Blueprint $table): void {
            $table->text('revoke_reason')->nullable()->after('resolved_at');
        });
    }

    public function down(): void
    {
        Schema::table('warning_letters', function (Blueprint $table): void {
            $table->dropColumn('revoke_reason');
        });
    }
};
