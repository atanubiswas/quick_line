<?php
// database/migrations/2025_06_28_000000_create_doctor_price_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctor_price_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->unsignedBigInteger('price_group_id');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->foreign('price_group_id')->references('id')->on('study_price_group')->onDelete('cascade');
            $table->unique(['doctor_id', 'price_group_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_price_settings');
    }
};
