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
            $table->integer('purchase_id')->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->integer('lumber_id')->nullable();
            $table->foreign('lumber_id')->references('id')->on('lumbers');
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
