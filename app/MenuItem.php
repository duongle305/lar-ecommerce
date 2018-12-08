<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MenuItem
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\MenuItem[] $children
 * @property-read \App\MenuItem $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MenuItem query()
 * @mixin \Eloquent
 */
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
        return $this->hasMany('App\MenuItem','parent_id')->with(['children']);
    }

}
