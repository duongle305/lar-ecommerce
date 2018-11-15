<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['name','note'];
    public function menuItem()
    {
        return $this->hasMany('App\MenuItem','menu_id','id')
            ->where('parent_id',NULL)
            ->with(['children'])
            ->get();
    }
}
