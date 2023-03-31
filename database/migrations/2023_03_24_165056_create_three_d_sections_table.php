<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreeDSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threed_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('threed_schedule_id')->index()->nullable();
            $table->timestamp('opening_date_time')->nullable();
            $table->integer('multiply')->nullable();
            $table->double('minimum_amount')->nullable();
            $table->double('maximum_amount')->nullable();
            $table->string('winning_number')->nullable();
            $table->text('numbers_info');
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
        Schema::dropIfExists('three_d_sections');
    }
}
