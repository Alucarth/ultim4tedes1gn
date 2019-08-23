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
            $table->decimal('density',13,2);
            $table->decimal('high',13,2);
            $table->decimal('width',13,2);
            $table->string('completed_type');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('array_type')->nullable();
            $table->decimal('amount',13,2)->default(0);
            $table->integer('product_type_id')->unsigned();
            $table->foreign('product_type_id')->references('id')->on('product_types');            
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
