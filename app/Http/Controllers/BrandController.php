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
                    $text = $brand->state == 1 ? 'Không hiển thị': 'Hiển thị';
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item change" 
                                       data-id="'.$brand->id.'"
                                       data-change="'.route('brands.change',$brand->id).'" >
                                    <i class="ti-reload"></i> '.$text.'</a>
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-id="'.$brand->id.'" 
                                       data-edit="'.route('brands.edit',$brand->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_edit_brand" >
                                    <i class="ti-pencil"></i> Sửa</a>
                                    <a href="#" 
                                       class="dropdown-item delete" 
                                       data-id="'.$brand->id.'"
                                       data-delete="'.route('brands.delete',$brand->id).'" >
                                    <i class="ti-trash"></i> Xóa</a>
                                </div>
                            </div>';
                })
                ->addColumn('note',function($brand){
                    return $brand->note ?? 'N/A';
                })
                ->addColumn('state',function($brand){
                    return $brand->state == 1? '<div class="text-success text-center">Hiển thị</div>' : '<div class="text-danger text-center">Không hiển thị</div>';
                })
                ->addColumn('logo',function ($brand){
                    return $brand->logo ?
                        '<div class="text-center"><img style="width: auto;height: 60px;" class="rounded" src="'.asset($brand->logo).'"/></div>' :
                        '<div class="text-center"><img style="width: auto;height: 60px;" class="rounded" src="'.asset('storage/uploads/brand_logo/default_logo.png').'"/></div>';
                })
                ->addIndexColumn()
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions','logo','state'])
                ->make(true);
        }catch (\Exception $e){
            return response()->json([],200);
        }
    }

    public function create()
    {

    }

    private function uploadLogo(Request $request, $key){
        if($request->hasFile($key)){
            $logo = $request->file($key);
            $logoName = time().'-'.$logo->getClientOriginalName();
            $logo->move(storage_path('app/public/uploads/brand_logo'),$logoName);
            return 'storage/uploads/brand_logo/'.$logoName;
        }
        return 'default_logo.png';
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
            'create_brand_name'=>'required|string|unique:brands,name',
            'create_brand_note'=>'nullable|string',
            'create_brand_logo' => 'required|file|mimes:jpeg,jpg,png,gif'
        ],[],[
            'create_brand_name'=>'tên hiển thị',
            'create_brand_note'=>'mô tả',
            'create_brand_logo' => 'Logo'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

        $brand = Brand::create([
            'name' => $request->create_brand_name,
            'slug' => str_slug($request->create_brand_name),
            'note' => $request->create_brand_note,
            'logo' => $this->uploadLogo($request,'create_brand_logo'),
        ]);

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
                $brand->logo_url = asset($brand->logo)
            ;
            return response()->json($brand,200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu'],500);
    }

    public function getInfoChangeBrand($id){
        $brand = Brand::find($id);
        if($brand instanceof Brand){
            return response()->json($brand,200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu'],500);
    }

    public function getBrands(Request $request){
        $keyword = $request->keyword;
        $currentCrand = $request->current_brand;
        $brands = Brand::where('name','like',"%{$keyword}%")
            ->where('id','!=',$currentCrand)
            ->paginate(10);

        return response()->json($brands,200);
    }

    public function transferSubmit(Request $request){
        $validator = Validator::make($request->all(),[
            'transfer_brand_id'=>'required|exists:brands,id',
            'transfer_brand'=>'required|exists:brands,id',
        ],[],[
            'transfer_brand_id'=>'Thương hiệu hiện tại',
            'transfer_brand'=>'Thương hiệu mới',
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);


        $brand = Brand::find($request->transfer_brand_id);

        if($brand instanceof Brand){
            $products = $brand->products;
            foreach ($products as $product){
                $product->brand_id = $request->transfer_brand;
                $product->save();
            }
            return $this->destroy($brand->id);
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
            'edit_brand_name'=>'required|string',
            'edit_brand_note'=>'nullable|string',
            'edit_brand_logo' => 'nullable|file|mimes:jpeg,jpg,png,gif'
        ],[],[
            'edit_brand_name'=>'tên hiển thị',
            'edit_brand_note'=>'mô tả',
            'edit_brand_logo' => 'Logo'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        $brand = Brand::find($request->edit_brand_id);
        if($brand instanceof Brand){
            $brand->update([
                'name' => $request->edit_brand_name,
                'slug' => str_slug($request->edit_brand_name),
                'note' => $request->edit_brand_note
            ]);

            if($request->hasFile('edit_brand_logo')){
                $logo = $request->file('edit_brand_logo');
                $logoName = time().'-'.$logo->getClientOriginalName();
                $logo->move(storage_path('app/public/uploads/brand_logo'),$logoName);
                if(!empty($brand->logo)){
                    if(File::exists(storage_path($brand->logo)))
                        File::delete(storage_path($brand->logo));
                }
                $brand->logo = 'storage/uploads/brand_logo/'.$logoName;
                $brand->save();
            }
            return response()->json(['message' => 'Cập nhật thương hiệu thành công!'],200);
        }
        return response()->json(['message' => 'Không tìm thấy dữ liệu phù hợp!'],500);
    }

    public function changeStatus($id){
        $brand = Brand::find($id);

        if($brand instanceof Brand){
            if($brand->state == 1){
                $brand->state = 0;
                $brand->save();
            } else {
                $brand->state = 1;
                $brand->save();
            }

            return response()->json(['message'=>'Thay đổi trạng thái thành công!'],200);
        }
        return response()->json(['message','Không tìm thấy dữ liệu'],500);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if($brand instanceof Brand){
            if($brand->products->count() > 0){
                return response()->json(['has_product'=> $brand->products->count(),'message'=>'Thương hiệu này đang có sản phẩm, Vui lòng chuyển hoặc xóa các sản phẩm trước khi xóa thương hiệu này'],200);
            }

            if(!empty($brand->logo)){
                if(File::exists(storage_path($brand->logo)))
                    File::delete(storage_path($brand->logo));
            }
            $brand->delete();
            return response()->json(['message'=>'Xóa thương hiệu <strong>'.$brand->name.'</strong> thành công.'],200);
        }
        return response()->json(['message' => 'Không tìm thấy dữ liệu phù hợp!'],500);
    }
}
