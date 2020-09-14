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
            $table->smallInteger('entirety_rank')->deault(0)->command('整體運勢等級');
            $table->text('entirety')->nullable()->command('整體運勢');
            $table->smallInteger('love_rank')->deault(0)->command('愛情運勢等級');
            $table->text('love')->nullable()->command('愛情運勢');
            $table->smallInteger('work_rank')->deault(0)->command('事業運勢等級');
            $table->text('work')->nullable()->command('事業運勢');
            $table->smallInteger('wealth_rank')->deault(0)->command('財運運勢等級');
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
