<?php

namespace App\Http\Controllers;

use App\Setting;
use Hamcrest\Core\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index(){
        $logo = Setting::where('title','logo')->first();
        return view('settings.index',compact(['logo']));
    }

    public function updateLogo(Request $request){
        $validator = Validator::make($request->all(),[
            'setting_id'=>'required|exists:settings,id',
            'web_logo' => 'required|file|mimes:jpeg,jpg,png,gif',
            'web_logo_note' => 'nullable|string'
        ],[],[
            'setting_id'=>'',
            'web_logo' => 'Logo',
            'web_logo_note' => 'Ghi chú'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);


        $setting = Setting::find($request->setting_id);

        $newLogo = $request->file('web_logo');

        $newName = 'web_logo.'.$newLogo->getClientOriginalExtension();

        $tmp = explode('/',$setting->value);
        $oldLogo = $tmp[count($tmp) -1];

        if(File::exists(storage_path('app/public/uploads/web_logo/'.$oldLogo)))
            File::delete(storage_path('app/public/uploads/web_logo/'.$oldLogo));

        $newName = 'web_logo.'.$newLogo->getClientOriginalExtension();
        $newLogo->move(storage_path('app/public/uploads/web_logo'),$newName);

        $setting->value = 'storage/uploads/web_logo/'.$newName;

        $setting->note = $request->web_logo_note;

        $setting->save();

        return response()->json(['message'=>'Cập nhật logo web thành công'],200);
    }

}
