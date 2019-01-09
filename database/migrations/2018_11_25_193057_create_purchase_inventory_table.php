<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('buyout_id')->nullable();
            $table->foreign('buyout_id')->references('id')->on('buyouts');
            $table->integer('inventory_id')->nullable();
            $table->foreign('inventory_id')->references('id')->on('inventorys');            
            $table->integer('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');
            $table->integer('quantity')->default(0);
            $table->decimal('price',13,2)->default(0);
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
        Schema::dropIfExists('purchase_inventory');
    }
}
