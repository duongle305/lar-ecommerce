<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table='provinces';
    protected $fillable=['id','name','slug_name','type',''];

    public function district(){
        return $this->hasMany('App\District');
    }
}
