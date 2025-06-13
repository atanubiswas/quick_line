<?php
// database/migrations/2025_06_11_000001_create_study_price_group_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('study_price_group', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('default_price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('study_price_group');
    }
};
