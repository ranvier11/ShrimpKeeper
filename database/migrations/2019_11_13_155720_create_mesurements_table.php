<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMesurementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesurements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tank_id');
            $table->smallInteger('tempC')->nullable();
            $table->float('ph')->nullable();
            $table->smallInteger('kh')->nullable();
            $table->smallInteger('gh')->nullable();
            $table->smallInteger('no3')->nullable();
            $table->smallInteger('ppm')->nullable();
            $table->smallInteger('us')->nullable();
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
        Schema::dropIfExists('mesurements');
    }
}
