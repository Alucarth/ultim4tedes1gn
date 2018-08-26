<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLumberInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lumber_inventories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('minimum')->default(0);
            $table->integer('maximum')->default(0);
            $table->integer('average')->default(0);
            $table->integer('lumber_id')->nullable();
            $table->foreign('lumber_id')->references('id')->on('lumbers');
            $table->integer('quantity')->default(0);
            $table->decimal('price',4,4)->deault(0.00000);            
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
        Schema::dropIfExists('lumber_inventories');
    }
}
