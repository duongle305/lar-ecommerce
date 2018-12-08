<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table='sliders';
    protected $fillable=['img_path','url','state'];
    public $timestamps= true;
}
