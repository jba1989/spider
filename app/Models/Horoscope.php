<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horoscope extends Model
{
    /**   
     * @var array
     */
    protected $fillable = [
        'date', 'zodiac', 'entirety_rank', 'entirety', 'love_rank', 'love', 'work_rank', 'work', 'wealth_rank', 'wealth'
    ];
}
