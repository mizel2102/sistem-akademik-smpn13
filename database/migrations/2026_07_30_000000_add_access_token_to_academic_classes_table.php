<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('academic_classes', function (Blueprint $table) {
            if (! Schema::hasColumn('academic_classes', 'access_token')) {
                $table->string('access_token', 10)->nullable()->unique()->after('schedule');
            }
        });
    }

    public function down(): void
    {
        Schema::table('academic_classes', function (Blueprint $table) {
            if (Schema::hasColumn('academic_classes', 'access_token')) {
                $table->dropColumn('access_token');
            }
        });
    }
};
