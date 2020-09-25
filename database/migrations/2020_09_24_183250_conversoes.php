<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Conversoes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conversoes',function(Blueprint $conversoes){
            $conversoes->increments('id')->unique();
            $conversoes->string('email');
            $conversoes->double('value_before_convertion',8,2)->unsigned();
            $conversoes->string('currency_origin');
            $conversoes->string('target_currency');
            $conversoes->string('value_after_convertion');
            $conversoes->string('target_currency_quote');
            $conversoes->string('source_currency_quote');
            $conversoes->timestamps();
            $conversoes->foreign('email')->references('email')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversoes');
    }
}
