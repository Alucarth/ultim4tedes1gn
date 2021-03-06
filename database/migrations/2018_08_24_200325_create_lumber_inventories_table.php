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
            $table->integer('minimum')->default(0);		//parametros de alerta
            $table->integer('maximum')->default(0);
            $table->integer('average')->default(0);		//promedio 
            $table->integer('lumber_id')->unsigned()->nullable();
            $table->foreign('lumber_id')->references('id')->on('lumbers');
            $table->integer('quantity')->default(0);
            $table->decimal('price',13,5)->deault(0.00000); //precio unitario 
          	$table->integer('storage_id')->unsigned();
          	$table->foreign('storage_id')->references('id')->on('storages');
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
        Schema::dropIfExists('lumber_inventories');
    }
}
