<?php

namespace App\Http\Controllers;

use App\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    public function index(){
        return view('sliders.index',compact([]));
    }

    public function allSliders(){
        try{
            return  DataTables::of(Slider::all())
                ->addColumn('actions',function($slider){
                    $text = $slider->state == 'ACTIVE' ? 'Không hiển thị' : 'Hiển thị';
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item change" 
                                       data-change="'.route('sliders.change-state',$slider->id).'">
                                    <i class="ti-reload"></i> '.$text.'</a>
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-id="'.$slider->id.'" 
                                       data-edit="'.route('sliders.edit',$slider->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_edit_slider" >
                                    <i class="ti-pencil"></i> Sửa</a>
                                    <a href="#" 
                                       class="dropdown-item delete" 
                                       data-id="'.$slider->id.'"
                                       data-delete="'.route('sliders.delete',$slider->id).'" >
                                    <i class="ti-trash"></i> Xóa</a>
                                </div>
                            </div>';
                })
                ->addColumn('note',function($slider){
                    return $slider->note ?? 'N/A';
                })
                ->addColumn('url',function($slider){
                    return '<a href="'.$slider->url.'">'.$slider->url.'</a>';
                })
                ->addColumn('image',function ($slider){
                    return '<div class="text-center"><img style="width: 100px" src="'.asset($slider->img_path).'"/></div>';
                })
                ->addColumn('state',function ($slider){
                    return ($slider->state == 'ACTIVE') ? '<div class="text-success">Hiển thị</div>' : '<div class="text-danger">Không hiển thị</div>';
                })
                ->addIndexColumn()
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions','image','state','url'])
                ->make(true);
        }catch (\Exception $e){
            return response()->json([],200);
        }
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'create_slider_url'=>'required|string|regex:/^(https?:\/\/)?(http?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'create_slider_note'=>'nullable|string',
            'create_slider_image' => 'required|file|mimes:jpeg,jpg,png,gif'
        ],[],[
            'create_slider_url'=>'Liên kết',
            'create_slider_note'=>'Ghi chú',
            'create_slider_image' => 'Ảnh slide'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

        $image = $request->file('create_slider_image');
        $newName = time().'-'.$image->getClientOriginalName();
        $image->move(storage_path('app/public/uploads/slider_images'),$newName);
        Slider::create([
            'url' => $request->create_slider_url,
            'img_path' => 'storage/uploads/slider_images/'.$newName,
            'state' => 'ACTIVE',
            'note' => $request->create_slider_note
        ]);

        return response()->json(['message'=>'Tạo mới Slider thành công'],200);
    }

    public function edit($id){
        $slider = Slider::find($id);
        if($slider instanceof Slider){
            $slider->image_url = asset($slider->img_path);
            return response()->json($slider,200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu'],500);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(),[
            'edit_slider_url'=>'required|string|regex:/^(https?:\/\/)?(http?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'edit_slider_note'=>'nullable|string',
            'edit_slider_image' => 'nullable|file|mimes:jpeg,jpg,png,gif',
            'edit_slider_id' =>'required|exists:sliders,id'
        ],[],[
            'edit_slider_url'=>'Liên kết',
            'edit_slider_note'=>'Ghi chú',
            'edit_slider_image' => 'Ảnh slide',
            'edit_slider_id' => 'ID slider'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

        $slider = Slider::find($request->edit_slider_id);

        $slider->url = $request->edit_slider_url;
        $slider->note = $request->edit_slider_note;

        if($request->hasFile('edit_slider_image')){
            $image = $request->file('edit_slider_image');
            $newName = time().'-'.$image->getClientOriginalName();
            $tmp = explode('/',$slider->img_path);
            if(File::exists(storage_path('app/public/uploads/slider_images/'.$tmp[count($tmp) -1])))
                File::delete(storage_path('app/public/uploads/slider_images/'.$tmp[count($tmp) -1]));

            $image->move(storage_path('app/public/uploads/slider_images'),$newName);
            $slider->img_path ='storage/uploads/slider_images/'.$newName;
        }
        $slider->save();

        return response()->json(['message'=>'Cập nhật thành công!'],200);
    }

    public function changeState($id){
        $slider = Slider::find($id);
        if($slider instanceof Slider){
            if($slider->state == 'ACTIVE'){
                $slider->state = 'INACTIVE';
                $slider->save();
            } else {
                $slider->state = 'ACTIVE';
                $slider->save();
            }
            return response()->json(['message'=>'Đổi trạng thái thành công!'],200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu'],500);
    }

    public function destroy($id){
        $slider = Slider::find($id);
        if($slider instanceof Slider){
            $tmp = explode('/',$slider->img_path);
            if(File::exists(storage_path('app/public/uploads/slider_images/'.$tmp[count($tmp) -1])))
                File::delete(storage_path('app/public/uploads/slider_images/'.$tmp[count($tmp) -1]));

            $slider->delete();
            return response()->json(['message'=>'Xóa thành công'],200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu'],500);
    }
}
