<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {    
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
            $table->softDeletes();
        });
           
        Schema::create('purchase_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_id')->nullable();
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->integer('expensive_id')->nullable();
            $table->foreign('expensive_id')->references('id')->on('expenses');
            $table->double('cost',13,2)->default(0);
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
        Schema::dropIfExists('purchase_expenses');
        Schema::dropIfExists('expenses');

    }
}
