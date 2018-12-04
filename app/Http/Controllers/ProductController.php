<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
    }

    public function index()
    {
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }


    public function allProducts(){
        try{
            return  DataTables::of(Product::all())
                ->addColumn('actions',function($product){
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-id="'.$product->id.'" 
                                       data-edit="'.route('products.edit',$product->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_edit_brand" >
                                    <i class="ti-pencil"></i> Sửa</a>
                                    <a href="#" 
                                       class="dropdown-item delete" 
                                       data-delete="'.route('products.delete',$product->id).'" >
                                    <i class="ti-trash"></i> Xóa</a>
                                </div>
                            </div>';
                })
                ->addColumn('thumbnail',function ($product){
                    return '<div class="text-center"><img style="width: auto;height: 60px;" class="rounded" src="'.asset('storage/uploads/product_images/'.$product->thumbnail).'"/></div>';
                })
                ->addIndexColumn()
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions'])
                ->make(true);
        }catch (\Exception $e){
            return response()->json([],200);
        }
    }

    public function getBrand(Request $request){
        $keyword = $request->keyword;
        $brands = Brand::where('name','like',"%{$keyword}%")
            ->orWhere('note','like',"%{$keyword}")
            ->orWhere('state','like',"%{$keyword}")
            ->select(['id','name'])->paginate(10);
        return response()->json($brands,200);
    }

    public function getCategories(Request $request){
       $keyword = $request->keyword;
       $categories = Category::whereNotNull('parent_id')
            ->where(function ($query) use($keyword){
                $query->where('title','like',"%{$keyword}%")
                ->orWhere('note','like',"%{$keyword}%");
            })
           ->select(['id','title'])
           ->paginate(10);

       $categories->getCollection()->transform(function ($category){
           $tmp = Category::where('parent_id','=',$category->id)->first();
           if(!$tmp instanceof Category){
               return $category;
           }
       });
       return response()->json($categories,200);

    }


    public function uploadImage(Request $request){
        $imageData = $this->uploadSingleImage($request,'description_image','product_description_image');
        return response()->json($imageData,200);
    }

    private function uploadSingleImage(Request $request,$fileName,$path){

        if($request->hasFile($fileName)){
            $image = $request->file($fileName);
            $newName = time().'-'.$image->getClientOriginalName();

            if(File::exists(storage_path('app/public/uploads/'.$path.'/'.$newName)))
                $newName = rand(100,999).$newName;

            $image->move(storage_path('app/public/uploads/'.$path),$newName);
            return ['image_url'=>asset('storage/uploads/'.$path.'/'.$newName),'image_name'=>$newName];
        }
    }

    public function deleteImage(Request $request){

    }

    private function deleteSingleImage($folder,$imageName){
        if(File::exists(storage_path('app/public/uploads/'.$folder.'/'.$imageName)))
            File::delete(storage_path('app/public/uploads/'.$folder.'/'.$imageName));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
