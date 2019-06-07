<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->integer('minimum');
            $table->integer('quantity')->nullable();
            $table->integer('inventory_type_id')->unsigned();
            $table->foreign('inventory_type_id')->references('id')->on('inventory_types');
            $table->integer('family_id')->unsigned();
            $table->foreign('family_id')->references('id')->on('families');
            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->string('description');
            $table->string('observation');
            $table->decimal('amount',13,2)->default(0);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('inventories');
    }
}
