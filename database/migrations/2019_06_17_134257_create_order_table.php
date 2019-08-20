<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->unsigned();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('type_id')->unsigned()->nullable();
            $table->foreign('type_id')->references('id')->on('types');
            $table->string('venesta')->nullable();
            $table->integer('construction_id')->unsigned();
            $table->foreign('construction_id')->references('id')->on('constructions');
            $table->string('name');
            $table->string('file')->nullable();
            $table->string('description')->nullable();
            $table->decimal('amount',13,2)->default(0);
            $table->integer('quantity')->unsigned()->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('estimated_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
