<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        if (! Schema::hasTable('teachers')) {
            Schema::create('teachers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('nip')->unique();
                $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete();
                $table->string('phone')->nullable();
                $table->string('address')->nullable();
                $table->timestamps();
            });
        }
        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
