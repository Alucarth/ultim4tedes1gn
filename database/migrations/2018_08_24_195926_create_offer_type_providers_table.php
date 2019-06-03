<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferTypeProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_type_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('offer_type_id')->unsigned();
            $table->foreign('offer_type_id')->references('id')->on('offer_types');   
            $table->integer('provider_id')->unsigned();
            $table->foreign('provider_id')->references('id')->on('providers');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_type_providers');
    }
}
