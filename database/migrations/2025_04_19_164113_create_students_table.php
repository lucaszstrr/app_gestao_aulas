<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id');
            $table->string('name');
            $table->string('responsible');
            $table->integer('age');
            $table->enum('school_year', ['fundamental 1', 'fundamental 2', 'ensino médio', 'ensino superior']);
            $table->string('school')->nullable();
            $table->unsignedBigInteger('number')->nullable();
            $table->decimal('class_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
