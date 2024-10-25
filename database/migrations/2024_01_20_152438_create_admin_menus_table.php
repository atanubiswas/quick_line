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
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();
            $table->string("menu_name", 255);
            $table->string("request", 255)->nullable();
            $table->string("icon", 255);
            $table->string("route", 255);
            $table->integer("parent_id")->default(0);
            $table->integer("menu_order")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_menus');
    }
};
