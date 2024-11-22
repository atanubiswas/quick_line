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
        Schema::create('doctor_logs', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['add','update','delete','active','inactive'])->default('add');
            $table->foreignId("doctor_id")->constrained();
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
        Schema::dropIfExists('doctor_logs');
    }
};
