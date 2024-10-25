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
        Schema::create('user_documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_type', 255);
            $table->string('document_number', 255);
            $table->string('document_front_image', 255);
            $table->string('document_back_image', 255)->nullable();
            $table->date('document_start_date')->nullable();
            $table->date('document_end_date')->nullable();
            $table->foreignId("user_id")->constrained();
            $table->smallInteger("status")->default(0);
            $table->integer("approved_by")->default(0);
            $table->date("approved_on")->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_documents');
    }
};
