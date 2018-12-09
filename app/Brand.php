<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Brand
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Brand query()
 * @mixin \Eloquent
 */
class Brand extends Model
{
    protected $fillable = ['name', 'slug', 'logo','state','note'];

    public function products(){
        return $this->hasMany('App\Product','brand_id','id');
    }
}
