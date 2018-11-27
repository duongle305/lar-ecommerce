<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Menu
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu query()
 * @mixin \Eloquent
 */
class Menu extends Model
{
    protected $fillable = ['name','note'];
    protected $hidden = ['updated_at','created_at'];
    public function menuItem()
    {
        return $this->hasMany('App\MenuItem','menu_id','id')
            ->where('parent_id',NULL)
            ->with(['children'])
            ->orderBy('orders')
            ->get(['id','title','slug','icon_class','url','route','parameters','target','parent_id']);
    }
}
