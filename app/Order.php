<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['customer_id','customer','address','phone_nb','note','order_status_id'];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function detail(){
        return $this->hasOne('App\OrderDetail','order_id');
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\OrderStatus');
    }

}
