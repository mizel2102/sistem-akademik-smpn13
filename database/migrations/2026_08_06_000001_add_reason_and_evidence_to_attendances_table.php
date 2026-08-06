<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            if (! Schema::hasColumn('attendances', 'reason')) {
                $table->text('reason')->nullable()->after('selfie_path');
            }
            if (! Schema::hasColumn('attendances', 'evidence_path')) {
                $table->string('evidence_path')->nullable()->after('reason');
            }
            
            // Make GPS coordinates and distance nullable for sick/permission/alpha statuses
            $table->decimal('latitude', 10, 7)->nullable()->change();
            $table->decimal('longitude', 10, 7)->nullable()->change();
            $table->unsignedSmallInteger('distance')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn(['reason', 'evidence_path']);
            $table->decimal('latitude', 10, 7)->nullable(false)->change();
            $table->decimal('longitude', 10, 7)->nullable(false)->change();
            $table->unsignedSmallInteger('distance')->nullable(false)->change();
        });
    }
};
