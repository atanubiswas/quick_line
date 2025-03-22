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
        Schema::create('lab_preferred_doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laboratorie_id')->constrained();
            $table->foreignId("doctor_id")->constrained();
            $table->foreignId("modality_id")->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_preferred_doctors');
    }
};
