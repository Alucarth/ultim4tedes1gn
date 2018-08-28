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
            $table->string('code')->nullable();
            $table->integer('quality_id')->nullable();
            $table->foreign('quality_id')->references('id')->on('qualities');
            $table->integer('specie_id')->nullable();
            $table->foreign('specie_id')->references('id')->on('species');
            $table->decimal('high',13,2);
            $table->decimal('wide',13,2);
            $table->decimal('length',13,2);
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
        Schema::dropIfExists('lumbers');
    }
}
