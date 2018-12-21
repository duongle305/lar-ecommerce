<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $children
 * @property-read \App\Category $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected $fillable = ['title','slug','parent_id','note','menu_icons','orders'];
    protected $hidden = ['created_at','updated_at'];


    public function products()
    {
        return $this->belongsToMany('App\Product','category_product');
    }
    public function parent()
    {
        return $this->belongsTo('App\Category');
    }

    public function children()
    {
        return $this->hasMany('App\Category','parent_id')->with(['children']);
    }
    public static function tree()
    {
        return static::where('parent_id',NULL)
            ->with(['children'])
            ->orderBy('orders')
            ->get(['id','title','slug','menu_icons','parent_id','note']);
    }
}
