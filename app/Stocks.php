<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stocks extends Model
{
    protected $table = 'stocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ingredient_id', 'bought_date', 'brand', 'bought_num', 'price', 'expire'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
}
