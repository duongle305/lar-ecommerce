<?php

namespace App\Http\Controllers\Api;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(){
        $categories =  Category::tree();
        return response()->json($categories, 200);
    }

    public function products($category)
    {
        $products = Category::whereSlug($category)->first()->products()->select(['id','title','slug','thumbnail','price','discount'])->paginate(8);
        return response()->json($products,200);
    }
}
