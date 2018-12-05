<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = ['order_id','product_id','quantity'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
