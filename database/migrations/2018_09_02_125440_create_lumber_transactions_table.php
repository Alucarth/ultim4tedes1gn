<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLumberTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lumber_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lumber_id');
            $table->foreign('lumber_id')->references('id')->on('lumbers');
            $table->integer('package_origin_id');
            $table->foreign('package_origin_id')->references('id')->on('packages');
            $table->integer('package_destination_id');
            $table->foreign('package_destination_id')->references('id')->on('packages');  
            $table->integer('quantity')->default(0); 
            $table->decimal('quantity_feet',13,2)->default(0);      		
            $table->date('date');
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
        Schema::dropIfExists('lumber_transactions');
    }
}
