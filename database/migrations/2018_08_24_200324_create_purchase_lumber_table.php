<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseLumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_lumber', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id')->unsigned()->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->integer('lumber_id')->unsigned()->nullable();
            $table->foreign('lumber_id')->references('id')->on('lumbers');
            $table->integer('state_id')->unsigned()->nullable();
            $table->foreign('state_id')->references('id')->on('states');
            $table->integer('origin_type_id')->unsigned()->nullable();
            $table->foreign('origin_type_id')->references('id')->on('origin_types');
            $table->integer('quantity')->default(0);
            $table->decimal('quantity_feet',13,2)->default(0);
            $table->decimal('amount',13,2)->nullable();
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
        Schema::dropIfExists('purchase_lumber');
    }
}
