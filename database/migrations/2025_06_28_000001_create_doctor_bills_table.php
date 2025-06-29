<?php
// database/migrations/2025_06_28_000001_create_doctor_bills_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctor_bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_amount', 10, 2);
            $table->integer('total_cases');
            $table->json('bill_data');
            $table->boolean('is_paid')->default(false);
            $table->unsignedBigInteger('paid_by')->nullable();
            $table->string('bill_number')->unique()->nullable(); // Added bill_number field
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
            $table->unique(['doctor_id', 'start_date', 'end_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_bills');
    }
};
