<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoroscopesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horoscopes', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->command('日期');
            $table->string('zodiac');
            $table->text('entirety')->nullable()->command('整體運勢');
            $table->text('love')->nullable()->command('愛情運勢');
            $table->text('work')->nullable()->command('事業運勢');
            $table->text('wealth')->nullable()->command('財運運勢');
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
        Schema::dropIfExists('horoscopes');
    }
}
