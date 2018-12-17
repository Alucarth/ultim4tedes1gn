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
            $table->integer('purchase_id')->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchases');
            //$table->integer('lumber_id')->nullable();
            //$table->foreign('lumber_id')->references('id')->on('lumbers');
            $table->integer('purchasable_id');
            $table->string('purchaseable_type');
            $table->integer('state_id')->nullable();
            $table->foreign('state_id')->references('id')->on('states');
            $table->integer('quantity')->default(0);
            $table->decimal('quantity_feet',13,2)->default(0);
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
