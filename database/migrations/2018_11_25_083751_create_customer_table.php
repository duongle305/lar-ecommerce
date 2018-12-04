<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('address')->nullable();
            $table->string('another_address')->nullable();
            $table->string('phone')->nullable();
            $table->enum('state',['ACTIVE','INACTIVE'])->default('INACTIVE');
            $table->date('birthday')->nullable();
            $table->string('avatar')->default('customer_default.png');
            $table->enum('gender',['M','F'])->default('M');
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
