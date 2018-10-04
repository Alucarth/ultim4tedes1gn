<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name');
            $table->string('identity_card');
            $table->string('item');
            $table->date('entry_date');
            $table->date('departure_date');
            $table->decimal('salary',13,2);
            $table->decimal('bonus',13,2);
            $table->decimal('extra_hour',13,2);
            $table->integer('official_area_id')->nullable();
            $table->foreign('official_area_id')->references('id')->on('areas');
            $table->integer('temporal_area_id')->nullable();
            $table->foreign('temporal_area_id')->references('id')->on('areas');
            $table->integer('positions_id')->nullable();
            $table->foreign('positions_id')->references('id')->on('positions');
            $table->integer('employee_contract_type_id')->nullable();
            $table->foreign('employee_contract_type_id')->references('id')->on('employee_contract_types');
            $table->integer('employee_type_id')->nullable();
            $table->foreign('employee_type_id')->references('id')->on('employee_types');
            $table->boolean('active')->default(false);
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
        Schema::dropIfExists('employees');
    }
}
