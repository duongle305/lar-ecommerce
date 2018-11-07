<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('menu_id');
            $table->string('title');
            $table->string('slug');
            $table->string('icon_class')->nullable();
            $table->string('url')->nullable();
            $table->string('route')->nullable();
            $table->string('parameters')->nullable();
            $table->string('target')->default('_self');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('orders')->nullable();
            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::table('menu_items', function(Blueprint $table){
            $table->foreign('parent_id')->references('id')->on('menu_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
