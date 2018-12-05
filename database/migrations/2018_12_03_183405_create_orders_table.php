<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_statuses', function(Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->text('note')->nullable();
            $table->timestamps();
        });
        Schema::create('order_status_switches', function(Blueprint $table){
            $table->unsignedInteger('current_status_id');
            $table->unsignedInteger('next_status_id');
            $table->foreign('current_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
            $table->foreign('next_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
            $table->primary(['current_status_id','next_status_id']);
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->string('customer')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_nb')->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('order_status_id');
            $table->foreign('order_status_id')->references('id')->on('order_statuses')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('order_details', function(Blueprint $table){
            $table->unsignedInteger('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedInteger('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedInteger('quantity')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
