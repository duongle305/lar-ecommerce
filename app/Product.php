<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps= true;
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
}
