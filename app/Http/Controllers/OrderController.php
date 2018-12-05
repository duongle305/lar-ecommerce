<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function allOrders()
    {
        try{
            $orders = Order::all();
            return \DataTables::of($orders)
                ->make(true);
        }catch (\Exception $e){
            return $e;
        }
    }


}
