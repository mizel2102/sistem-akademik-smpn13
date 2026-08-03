<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'nis')) {
                $table->string('nis')->nullable()->unique()->after('user_id');
            }
            if (! Schema::hasColumn('students', 'academic_class_id')) {
                $table->foreignId('academic_class_id')->nullable()->constrained('academic_classes')->nullOnDelete()->after('grade_level');
            }
            if (! Schema::hasColumn('students', 'gender')) {
                $table->string('gender')->nullable()->after('academic_class_id');
            }
            if (! Schema::hasColumn('students', 'birthplace')) {
                $table->string('birthplace')->nullable()->after('gender');
            }
            if (! Schema::hasColumn('students', 'birthdate')) {
                $table->date('birthdate')->nullable()->after('birthplace');
            }
            if (! Schema::hasColumn('students', 'address')) {
                $table->text('address')->nullable()->after('birthdate');
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'address')) {
                $table->dropColumn('address');
            }
            if (Schema::hasColumn('students', 'birthdate')) {
                $table->dropColumn('birthdate');
            }
            if (Schema::hasColumn('students', 'birthplace')) {
                $table->dropColumn('birthplace');
            }
            if (Schema::hasColumn('students', 'gender')) {
                $table->dropColumn('gender');
            }
            if (Schema::hasColumn('students', 'academic_class_id')) {
                $table->dropForeign(['academic_class_id']);
                $table->dropColumn('academic_class_id');
            }
            if (Schema::hasColumn('students', 'nis')) {
                $table->dropColumn('nis');
            }
        });
    }
};
