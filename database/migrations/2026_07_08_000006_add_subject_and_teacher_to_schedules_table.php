<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            if (! Schema::hasColumn('schedules', 'subject_id')) {
                $table->foreignId('subject_id')
                    ->after('semester_id')
                    ->constrained('subjects')
                    ->cascadeOnDelete();
            }

            if (! Schema::hasColumn('schedules', 'teacher_id')) {
                $table->foreignId('teacher_id')
                    ->after('subject_id')
                    ->constrained('teachers')
                    ->cascadeOnDelete();
            }
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->index(['academic_class_id', 'academic_year_id', 'semester_id', 'day'], 'schedules_class_period_day_index');
            $table->index(['teacher_id', 'academic_year_id', 'semester_id', 'day'], 'schedules_teacher_period_day_index');
        });
    }

    public function down(): void
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropIndex('schedules_class_period_day_index');
            $table->dropIndex('schedules_teacher_period_day_index');

            if (Schema::hasColumn('schedules', 'teacher_id')) {
                $table->dropConstrainedForeignId('teacher_id');
            }

            if (Schema::hasColumn('schedules', 'subject_id')) {
                $table->dropConstrainedForeignId('subject_id');
            }
        });
    }
};
