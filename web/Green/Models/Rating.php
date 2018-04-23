<?php
namespace Green\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Rating extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'recipe_id', 'stars'
    ];
}