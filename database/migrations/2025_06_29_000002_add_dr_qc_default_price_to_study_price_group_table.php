<?php
// database/migrations/2025_06_29_000002_add_dr_qc_default_price_to_study_price_group_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('study_price_group', function (Blueprint $table) {
            $table->decimal('dr_default_price', 10, 2)->default(0.00)->after('default_price');
            $table->decimal('qc_default_price', 10, 2)->default(0.00)->after('dr_default_price');
        });
    }

    public function down()
    {
        Schema::table('study_price_group', function (Blueprint $table) {
            $table->dropColumn(['dr_default_price', 'qc_default_price']);
        });
    }
};
