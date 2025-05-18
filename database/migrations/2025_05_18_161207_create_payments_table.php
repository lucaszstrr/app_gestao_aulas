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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id');
            $table->integer('responsible_id')->nullable();
            $table->string('payer_pix_key');
            $table->string('beneficiary_pix_key')->nullable();
            $table->decimal('rent_value')->nullable();
            $table->decimal('classes_total_value')->nullable();
            $table->string('beneficiary');
            $table->boolean('rent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
