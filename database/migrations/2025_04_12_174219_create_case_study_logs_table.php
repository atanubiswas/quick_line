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
        Schema::create('case_study_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['add','view','update','delete','statusChange'])->default('add');
            $table->foreignId("case_study_id")->constrained();
            $table->string("log");
            $table->foreignId("user_id")->constrained();
            $table->string("column_name")->nullable();
            $table->string("old_value")->nullable();
            $table->string("new_value")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_study_logs');
    }
};
