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
        Schema::create('lab_modalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId("laboratory_id")->constrained();
            $table->foreignId("modality_id")->constrained();
            $table->smallInteger("status")->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_modalities');
    }
};
