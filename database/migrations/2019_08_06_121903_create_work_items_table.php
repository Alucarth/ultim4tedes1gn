<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_items', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('work_id');
            $table->foreign('work_id')->references('id')->on('works');
            $table->integer('area_id')->unsigned()->nullable(); // esto va en la tabla de tiempos
            $table->foreign('area_id')->references('id')->on('areas');
            $table->integer('task_id')->unsigned()->nullable(); // esto va en la tabla de tiempos
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->integer('product_id')->unsigned();
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders');
            $table->string('observation');
            $table->decimal('time');
            $table->decimal('quantity');
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
        Schema::dropIfExists('work_items');
    }
}
