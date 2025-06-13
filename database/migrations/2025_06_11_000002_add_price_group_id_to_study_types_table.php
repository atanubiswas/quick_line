<?php
// database/migrations/2025_06_11_000002_add_price_group_id_to_study_types_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('study_types', function (Blueprint $table) {
            // $table->unsignedBigInteger('price_group_id')->after('modality_id'); // Already exists
            // Ensure all price_group_id values are valid before adding the foreign key
            // You may want to manually update invalid values before running this migration
            $table->foreign('price_group_id')
                ->references('id')->on('study_price_group')
                ->onDelete('restrict');
        });
    }

    public function down()
    {
        Schema::table('study_types', function (Blueprint $table) {
            $table->dropForeign(['price_group_id']);
            $table->dropColumn('price_group_id');
        });
    }
};
