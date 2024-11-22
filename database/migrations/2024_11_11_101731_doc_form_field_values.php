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
        Schema::create('doc_form_field_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId("form_field_id")->constrained();
            $table->string("value")->nullable();
            $table->foreignId("doctor_id")->constrained();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->timestamps();
            
            $table->foreign('updated_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('SET NULL') // Define the action on delete if needed
                  ->onUpdate('CASCADE'); // Define the action on update if needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doc_form_field_values', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropColumn('updated_by');
        });
    }
};
