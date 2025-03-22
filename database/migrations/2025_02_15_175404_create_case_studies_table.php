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
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId("laboratory_id")->constrained();
            $table->foreignId("patient_id")->constrained();
            $table->foreignId("doctor_id")->constrained()->nullable();
            $table->foreignId("qc_id")->constrained("users")->nullable();
            $table->foreignId("assigner_id")->constrained("users")->nullable();
            $table->text("clinical_history")->nullable();
            $table->smallInteger(("is_emergency"))->default(0);
            $table->smallInteger(("is_post_operative"))->default(0);
            $table->smallInteger(("is_follow_up"))->default(0);
            $table->smallInteger(("is_subspecialty"))->default(0);
            $table->smallInteger(("is_callback"))->default(0);
            $table->foreignId("study_status_id")->constrained();
            $table->dateTime("status_updated_on")->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("case_studies");
    }
};
