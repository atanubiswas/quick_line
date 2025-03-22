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
        Schema::create('modality_study_layouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('study_type_id')->constrained();
            $table->text('layout');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->foreignId('created_by')->constrained('users')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modality_study_layouts');
    }
};
