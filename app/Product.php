<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Product
 *
 * @property-read \App\Brand $brand
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $categories
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Product query()
 * @mixin \Eloquent
 */
class Product extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'thumbnail',
        'description',
        'note',
        'code',
        'price',
        'discount',
        'quantity',
        'brand_id',
        'state',
    ];

    public function categories(){
        return $this->belongsToMany('App\Category','category_product');
    }

    public function brand(){
        return $this->belongsTo('App\Brand','brand_id','id');
    }

    public function images(){
        return $this->hasMany('App\ProductImage','product_id','id');
    }
    public function attributes(){
        return $this->hasMany('App\Attribute','product_id','id');
    }
}
