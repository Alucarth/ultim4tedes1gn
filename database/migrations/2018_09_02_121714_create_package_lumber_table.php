<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageLumberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_lumber', function(){
            $table->increments('id');
            $table->integer('package_id');
            $table->foreign('package_id')->references('id')->on('packages');
            $table->integer('lumber_id');
            $table->foreign('lumber_id')->references('id')->on('lumbers');
            $table->integer('quantity')->default(0);  
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
        Schema::dropIfExists('package_lumber');
    }
}
