<?php
// database/migrations/2025_06_11_000003_create_study_center_prices_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('study_center_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('center_id');
            $table->unsignedBigInteger('study_type_id');
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('center_id')->references('id')->on('laboratories')->onDelete('cascade');
            $table->foreign('study_type_id')->references('id')->on('study_types')->onDelete('cascade');
            $table->unique(['center_id', 'study_type_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_center_prices');
    }
};
