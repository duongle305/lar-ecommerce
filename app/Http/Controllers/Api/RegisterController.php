<?php

namespace App\Http\Controllers\Api;

use App\Province;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{

    public function getProvinces(Request $request)
    {
        $provinces = Province::where(function($query) use ($request){
            return $query->where('name','like',"%{$request->keyword}%")
                ->orWhere('slug','like',"%{$request->keyword}%");
        })->get(['id','name','slug','type']);
        return response()->json($provinces, 200);
    }
}
