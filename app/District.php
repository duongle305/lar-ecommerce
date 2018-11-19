<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table='districts';
    protected $fillable = ['id','name','slug_name','province_id','type'];
    public $timestamps =true;

    public function wards(){
        return $this->hasMany('App\Wards');
    }
    
    public function province(){
        return $this->belongsTo('App\Province');
    }
}
