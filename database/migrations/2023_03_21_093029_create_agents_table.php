<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->unique();
            $table->string('image')->nullable();
            $table->double('balance')->default(0);
            $table->string('display_password')->nullable();
            $table->string('password');

            $table->string('nrc_front_photo')->nullable();
            $table->string('nrc_back_photo')->nullable();
            $table->boolean('has_level2_account')->default(0);
            $table->double('commision_percent')->nullable();
            $table->string('contact')->nullable();


            $table->double('minimum_amount')->nullable();
            $table->double('maximum_amount')->nullable();
            $table->tinyInteger('current_mode')->default(1)->comment('1.Buy 2.Sell');
            $table->integer('duration')->nullable();

            $table->boolean('approved')->default(0);
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('last_logined_at')->nullable();
            $table->string('last_logined_ip')->nullable();
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
        Schema::dropIfExists('agents');
    }
}
