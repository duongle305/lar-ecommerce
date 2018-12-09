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

    public function search(Request $request)
    {
        $keyword = $request->keyword;
                $products = Product::leftJoin('brands','brands.id','=','products.id')
            ->where(function($query) use($keyword){
                $query->where('products.title','like',"%{$keyword}%")
                    ->orWhere('products.slug','like',"%{$keyword}%")
                    ->orWhere('brands.name','like',"%{$keyword}%")
                    ->orWhere('brands.slug','like',"%{$keyword}%");
            })
            ->get(['products.id','products.title','products.slug','products.thumbnail','products.price','products.discount']);
        return response()->json($products, 200);
    }
}
