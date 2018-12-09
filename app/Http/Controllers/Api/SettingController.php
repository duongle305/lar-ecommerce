<?php

namespace App\Http\Controllers\Api;

use App\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    public function logo(){
        $setting = Setting::where('title','logo')->first();
        return response()->json(asset($setting->value),200);
    }
}
