<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('density');
            $table->decimal('high',13,2);
            $table->decimal('width',13,2);
            $table->string('completed_type');
            $table->string('name');
            $table->string('description');
            $table->decimal('amount',13,2)->default(0);
            $table->integer('product_type_id')->unsigned();
            $table->foreign('product_type_id')->references('id')->on('product_types');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
