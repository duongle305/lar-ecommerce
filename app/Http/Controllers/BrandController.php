<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('brands.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function allBrands(){
        try{
            return  DataTables::of(Brand::all())
                ->addColumn('actions',function($brand){
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-id="'.$brand->id.'" 
                                       data-edit="'.route('brands.edit',$brand->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_edit_brand" >
                                    <i class="ti-pencil"></i> Sửa</a>
                                    <a href="#" 
                                       class="dropdown-item delete" 
                                       data-delete="'.route('brands.delete',$brand->id).'" >
                                    <i class="ti-trash"></i> Xóa</a>
                                </div>
                            </div>';
                })
                ->addColumn('note',function($brand){
                    return $brand->note ?? 'N/A';
                })
                ->addColumn('logo',function ($brand){
                    return $brand->logo ?
                        '<div class="text-center"><img style="width: 60px;height: 60px;" class="rounded" src="'.asset('storage/uploads/brand_logo/'.$brand->logo).'"/></div>' :
                        '<div class="text-center"><img style="width: 60px;height: 60px;" class="rounded" src="'.asset('storage/uploads/brand_logo/default_logo.png').'"/></div>';
                })
                ->addIndexColumn()
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions','logo'])
                ->make(true);
        }catch (\Exception $e){
            return response()->json([],200);
        }
    }

    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'create_brand_slug'=>'required|string|unique:brands,slug',
            'create_brand_name'=>'required|string|unique:brands,name',
            'create_brand_note'=>'nullable|string',
            'create_brand_logo' => 'nullable|file|mimes:jpeg,jpg,png,gif'
        ],[],[
            'create_brand_slug'=>'tên',
            'create_brand_name'=>'tên hiển thị',
            'create_brand_note'=>'mô tả',
            'create_brand_logo' => 'Logo'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

        $brand = Brand::create([
            'name' => $request->create_brand_name,
            'slug' => $request->create_brand_slug,
            'note' => $request->create_brand_note,
        ]);

        if($request->hasFile('create_brand_logo')){
            $logo = $request->file('create_brand_logo');
            $logoName = time().'-'.$logo->getClientOriginalName();
            $logo->move(storage_path('app/public/uploads/brand_logo'),$logoName);
            $brand->logo = $logoName;
            $brand->save();
        }
        return response()->json(['message' => "Tạo mới thương hiệu <b>{$brand->name}</b> thành công!"],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        if($brand instanceof Brand){
            empty($brand->logo) ?
                $brand->logo_url = asset('storage/uploads/brand_logo/default_logo.png'):
                $brand->logo_url = asset('storage/uploads/brand_logo/'.$brand->logo)
            ;
            return response()->json($brand,200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu'],500);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'edit_brand_slug'=>'required|string',
            'edit_brand_name'=>'required|string',
            'edit_brand_note'=>'nullable|string',
            'edit_brand_logo' => 'nullable|file|mimes:jpeg,jpg,png,gif'
        ],[],[
            'edit_brand_slug'=>'tên',
            'edit_brand_name'=>'tên hiển thị',
            'edit_brand_note'=>'mô tả',
            'edit_brand_logo' => 'Logo'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        $brand = Brand::find($request->edit_brand_id);
        if($brand instanceof Brand){
            $brand->update([
                'name' => $request->edit_brand_name,
                'slug' => $request->edit_brand_slug,
                'note' => $request->edit_brand_note
            ]);

            if($request->hasFile('edit_brand_logo')){
                $logo = $request->file('edit_brand_logo');
                $logoName = time().'-'.$logo->getClientOriginalName();
                $logo->move(storage_path('app/public/uploads/brand_logo'),$logoName);
                if(!empty($brand->logo)){
                    if(File::exists(storage_path('app/public/uploads/brand_logo/'.$brand->logo)))
                        File::delete(storage_path('app/public/uploads/brand_logo/'.$brand->logo));
                }
                $brand->logo = $logoName;
                $brand->save();
            }
            return response()->json(['message' => 'Cập nhật thương hiệu thành công!'],200);
        }
        return response()->json(['error' => 'Không tìm thấy dữ liệu phù hợp!'],500);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        if($brand->delete())
            if(!empty($brand->logo)){
                if(File::exists(storage_path('app/public/uploads/brand_logo/'.$brand->logo)))
                    File::delete(storage_path('app/public/uploads/brand_logo/'.$brand->logo));
            }
            return response()->json(['message'=>'Xóa thương hiệu <strong>'.$brand->name.'</strong> thành công.'],200);
        return response()->json(['message'=>'Đã xảy ra lỗi trong quá trình xử lý vui lòng kiểm tra lại.'],403);
    }
}
