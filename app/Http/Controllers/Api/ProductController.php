<?php

namespace App\Http\Controllers\Api;

use App\Product;
use http\Env\Response;
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

    public function getProduct($id){
        $product = Product::find($id);
        if($product instanceof Product){
            $images = $product->images;
            $images = $images->map(function ($item){
                $item->url = asset($item->path);
                return $item;
            });
            $product->images = $images;
            $product->brand_info = $product->brand;
            $product->attributes = $product->attributes;
            return response()->json($product,200);
        }
        return response()->json(['message'=>'Sản phẩm không tồn tại'],500);
    }
}
