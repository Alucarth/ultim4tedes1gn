<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('amount',13,2);
            $table->date('date',13,2);
            $table->foreign('client_id')->references('id')->on('clients');
            $table->integer('client_id')->unsigned()->nullable();
            // $table->foreign('contract_id')->references('id')->on('contracts');
            // $table->integer('contract_id')->unsigned()->nullable();
            $table->string('file')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('payments');
    }
}
