<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('centre_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_amount', 12, 2);
            $table->integer('total_study')->default(0);
            $table->json('bill_data'); // Store the bill table data as JSON
            $table->boolean('is_paid')->default(0);
            $table->unsignedBigInteger('paid_by')->nullable();
            $table->string('invoice_number')->unique();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->foreign('centre_id')->references('id')->on('laboratories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
};
