<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');            
            $table->string('name');
            $table->string('description');
            $table->string('file')->nullable();
            $table->integer('contract_type_id')->unsigned();
            $table->foreign('contract_type_id')->references('id')->on('contract_types');
            $table->integer('construction_id')->unsigned();
            $table->foreign('construction_id')->references('id')->on('constructions');
            $table->integer('employee_id')->unsigned()->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->decimal('amount',13,2)->default(0);
            $table->decimal('debt',13,2)->default(0);
            $table->decimal('sales_commission',13,2)->default(0);
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
        Schema::dropIfExists('contracts');
    }
}
