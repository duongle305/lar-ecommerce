<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    public function parent()
    {
        return $this->belongsTo('App\MenuItem');
    }

    public function children()
    {
        return $this->hasMany('App\MenuItem','parent_id');
    }
}
