<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_order', function (Blueprint $table) {
            //$table->increments('id');
            $table->integer('order_id')->unsigned()->nullable();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->integer('inventory_area_id')->unsigned()->nullable();
            $table->foreign('inventory_area_id')->references('id')->on('inventory_area');
            $table->integer('quantity')->default(0);
            $table->integer('used_quantity')->default(0);
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
        Schema::dropIfExists('inventory_order');
    }
}
