<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = ['name', 'slug', 'logo', 'note', '', ''];
    public $timestamps = true;

}
