<?php
// database/migrations/2025_06_11_000004_add_price_group_id_to_study_center_prices_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('study_center_prices', function (Blueprint $table) {
            $table->unsignedBigInteger('price_group_id')->after('study_type_id')->nullable();
            $table->foreign('price_group_id')->references('id')->on('study_price_group')->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('study_center_prices', function (Blueprint $table) {
            $table->dropForeign(['price_group_id']);
            $table->dropColumn('price_group_id');
        });
    }
};
