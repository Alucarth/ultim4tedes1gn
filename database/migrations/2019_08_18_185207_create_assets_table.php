<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('code')->nullable();
            $table->string('capacity')->nullable();
            $table->string('document')->nullable();
            $table->string('branch')->nullable();
            $table->string('detail')->nullable();
            $table->string('description')->nullable();
            $table->integer('asset_type_id')->unsigned();
            $table->foreign('asset_type_id')->references('id')->on('asset_types');
            $table->integer('area_id')->unsigned()->nullable();
            $table->foreign('area_id')->references('id')->on('areas');
            $table->string('location')->nullable();
            $table->string('file')->nullable();
            $table->date('date');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('price')->default(0.00);
            $table->decimal('worth')->default(0.00);
            $table->decimal('actual_price')->default(0.00);
            $table->decimal('depreciation',13,2)->default(0.00);
            $table->integer('quantity')->default(0);
            $table->integer('lifetime')->default(0);
            $table->decimal('revaluation')->default(0.0);
            $table->boolean('active')->default(true);
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
        Schema::dropIfExists('assets');
    }
}
