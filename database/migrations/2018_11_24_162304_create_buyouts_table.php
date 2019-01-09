<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('buyouts', function (Blueprint $table) {            
            $table->increments('id');            
            $table->integer('provider_id')->nullable();
            $table->foreign('provider_id')->references('id')->on('providers');
            $table->date('date');
            $table->string('description');
            $table->decimal('amount',13,2)->default(0);
            $table->integer('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
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
        Schema::dropIfExists('buyouts');
    }
}
