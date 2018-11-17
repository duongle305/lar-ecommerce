<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = ['menu_id','title','slug','icon_class','url','route','parameters','target','parent_id','orders'];
    protected $hidden = ['updated_at','created_at'];
    public function parent()
    {
        return $this->belongsTo('App\MenuItem');
    }

    public function children()
    {
        return $this->hasMany('App\MenuItem','parent_id');
    }
}
