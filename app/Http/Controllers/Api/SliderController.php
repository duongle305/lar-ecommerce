<?php

namespace App\Http\Controllers\Api;

use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::whereState('ACTIVE')->get(['id','img_path','url']);
        return response()->json($sliders, 200);
    }
}
