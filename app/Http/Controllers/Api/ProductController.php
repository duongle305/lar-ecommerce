<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function saleProducts()
    {
        $products = Product::where(function($query){
                $query->where('discount','>',0)
                    ->whereState('ACTIVE')
                    ->where('quantity','>',0);
            })->orderByDesc('discount')->limit(10)->get(['id','title','slug','thumbnail','price','discount']);
        return response()->json($products, 200);
    }
}
