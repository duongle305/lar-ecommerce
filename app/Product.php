<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'title',
        'slug',
        'description',
        'code',
        'price',
        'discount',
        'quantity',
        'status',
        'brand_id',
        'attitudes'
    ];
    public $timestamps= true;

    public function categories(){
        return $this->belongsToMany('App\Category','category_product');
    }

    public function brand(){
        return $this->belongsTo('APp/Brand','brand_id','id');
    }
}
