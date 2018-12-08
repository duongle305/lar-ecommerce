<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id','customer','address','phone_nb','note','order_status_id'];

    public function customerInfo()
    {
        return $this->belongsTo('App\Customer','customer_id','id');
    }

    public function details(){
        return $this->hasMany('App\OrderDetail','order_id','id');
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus','order_status_id','id');
    }


}
