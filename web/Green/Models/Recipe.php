<?php
namespace Green\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Recipe extends Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'prepare_time','vegetarian', 'difficulty'
    ];

    public function ratings()
    {
       return $this->hasMany(Rating::class);
    }

    public function scopeSearch($query, $key, $value)
    {
        /**
         * Here we only allowed limited column
         * they cant search using id or other
         */
        if( (in_array($key,$this->fillable) || $key==='rating') AND $value!=null ){

            if($key==="name"){
                return $query->where($key,"like","$value%");
            } else if($key==="rating") {
                return $query->whereHas('ratings',function ($query) use($value)
                {
                    $query->where('stars',$value);
                });
            }
            return $query->where($key,$value);
        }
    }
}