<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $table='attributes';
    protected $fillable=['title','slug','value'];
    public $timestamps = true;

    public function categories(){
        return $this->belongsToMany('App\Attribute','attribute_category');
    }
}
