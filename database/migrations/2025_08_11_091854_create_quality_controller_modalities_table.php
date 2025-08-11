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
        Schema::create('quality_controller_modalities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('qc_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('modality_id')->constrained('modalities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quality_controller_modalities');
    }
};
