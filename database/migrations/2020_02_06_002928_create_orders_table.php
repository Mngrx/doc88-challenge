<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('customer_id')->references('id')->on('customers');
        });

        Schema::create('orders_pastries', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('pastry_id');

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('pastry_id')->references('id')->on('pastries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_pastries');
        Schema::dropIfExists('orders');
    }
}
