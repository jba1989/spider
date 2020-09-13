<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horoscope extends Model
{
    /**   
     * @var array
     */
    protected $fillable = [
        'date', 'zodiac', 'entirety', 'love', 'work', 'wealth'
    ];
}
