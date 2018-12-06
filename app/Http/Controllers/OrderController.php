<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderStatus;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function allOrders($id)
    {

        try{
            $orders = Order::where('order_status_id',$id)
                ->orderBy('created_at', 'DESC')
                ->get();

            return \DataTables::of($orders)
                ->addColumn('actions',function($order){
                    $status = $order->orderStatus;
                    $nextStatuses = DB::table('order_status_switches')
                        ->where('current_status_id',$status->id)
                        ->get();
                    $html = '';
                    if($nextStatuses->count() > 0){
                        foreach ($nextStatuses as $item){
                            $statusTmp = OrderStatus::find($item->next_status_id);
                            $html.='<a href="#" data-url="'.route('orders.change-status',[$order->id,$statusTmp->id]).'"
                                       class="dropdown-item next-status">
                                    <i class="ti-arrow-right"></i> '.$statusTmp->name.'</a>';
                        }
                    }
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-url="'.route('orders.show',$order->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_order_detail" >
                                    <i class="ti-eye"></i> Chi tiết</a>
                                    '.$html.'
                                </div>
                            </div>';
                })
                ->addColumn('created_at',function ($order){
                    return date('d/m/Y H:i',strtotime($order->created_at));
                })
                ->addColumn('product_quantity',function ($order){
                    return 1;
                })

                ->addIndexColumn()
                ->rawColumns(['actions'])
                ->make(true);
        }catch (\Exception $e){
            return $e;
        }
    }

    public function show($id){
        $order = Order::find($id);
        if($order instanceof Order){
            $order->customer_info = $order->customerInfo;
            $order->status = $order->orderStatus->name;
            $order->order_date = date('d/m/Y, H:i',strtotime($order->created_at));
            $totalProduct = 0;

            foreach ($order->details as $detail) {
                $totalProduct+= $detail->quantity;
            }
            $order->total_product = $totalProduct;

            $total = 0;
            $orderDetails = $order->details;
            $products = [];
            foreach ($orderDetails as $item) {
                $product = Product::find($item->product_id);
                $product->order_price = number_format(($product->price - ($product->price*$product->discount)),0);
                $product->order_quantity = $item->quantity;
                $products[] = $product;
                $total += intval($item->quantity)*($product->price - ($product->price*$product->discount));
            }
            $order->total_price = number_format(ceil($total),0);
            $order->products = $products;
            $order->address ?? $order->address = $order->customerInfo->address;

            return response()->json($order,200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu phù hợp'],500);
    }

    public function changeStatus($orderID,$nextStatus){
        $order = Order::find($orderID);
        $status = OrderStatus::find($nextStatus);

        if($order instanceof Order && $status instanceof OrderStatus){
            $order->order_status_id = $status->id;
            $order->save();
            return response()->json(['message'=>'Đổi trạng thái "'.$status->name.'" thành công!'],200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu phù hợp'],500);
    }
}
