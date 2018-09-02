<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');//numero de secado
            $table->integer('package_id');
            $table->integer('package-id')->references('id')->on('packages');
            $table->integer('storage_origin_id');
            $table->integer('storage_origin_id')->references('id')->on('storages');
            $table->integer('storage_destination_id');
            $table->integer('storage_destination_id')->references('id')->on('storages');        		
            $table->date('date');
            $table->string('description');
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
        Schema::dropIfExists('package_transactions');
    }
}
