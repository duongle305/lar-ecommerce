<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::whereState(1)->get(['id','name','slug','logo']);
        return response()->json($brands, 200);
    }
}
