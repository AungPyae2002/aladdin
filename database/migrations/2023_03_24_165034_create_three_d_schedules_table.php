<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreeDSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threed_schedules', function (Blueprint $table) {
            $table->id();
            $table->date('opening_date')->nullable();
            $table->time('opening_time')->nullable();
            $table->integer('multiply')->nullable();
            $table->double('minimum_amount')->nullable();
            $table->double('maximum_amount')->nullable();
            $table->boolean('is_auto')->default(0);
            $table->text('auto_link')->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('three_d_schedules');
    }
}
