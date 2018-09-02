<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lumbers', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('type_id')->nullable();
            $table->foreign('type_id')->references('id')->on('types');
            $table->integer('specie_id')->nullable();
            $table->foreign('specie_id')->references('id')->on('species');
            $table->decimal('high',13,2);
            $table->decimal('width',13,2);
            $table->decimal('density',13,2);
            $table->string('description')->nullable();
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
        Schema::dropIfExists('lumbers');
    }
}
