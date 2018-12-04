<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Attribute
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attribute[] $categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attribute query()
 * @mixin \Eloquent
 */
class Attribute extends Model
{
    protected $table='attributes';
    protected $fillable=['title','slug','value'];
    public $timestamps = true;

    public function categories(){
        return $this->belongsToMany('App\Attribute','attribute_category');
    }
}
