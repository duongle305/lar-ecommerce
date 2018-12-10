<?php

namespace App\Http\Controllers;

use App\Attribute;
use App\Brand;
use App\Category;
use App\Product;
use App\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
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
                    $state = ($product->state == 'ACTIVE') ? 'Không hiển thị' : 'Hiển thị';
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item change-state" 
                                       data-change="'.route('products.change-state',$product->id).'" >
                                        <i class="ti-reload"></i> '.$state.'</a>
                                    <a href="#" 
                                       class="dropdown-item view" 
                                       data-view="'.route('products.show',$product->id).'" >
                                        <i class="ti-eye"></i> Xem</a>
                                    <a href="'.route('products.edit',$product->id).'" 
                                       class="dropdown-item" >
                                        <i class="ti-pencil"></i> Sửa</a>
                                    <a href="#" 
                                       class="dropdown-item delete" 
                                       data-delete="'.route('products.delete',$product->id).'" >
                                        <i class="ti-trash"></i> Xóa</a>
                                </div>
                            </div>';
                })
                ->addColumn('thumbnail',function ($product){
                    return '<div class="text-center"><img style="width: auto;height: 60px;" class="rounded" src="'.asset($product->thumbnail).'"/></div>';
                })
                ->addColumn('brand',function ($product){
                    return $product->brand->name;
                })
                ->addColumn('state',function ($product){
                    return $product->state == 'ACTIVE' ? '<div class="text-success">Hiển thị</div>' : '<div class="text-danger">Ẩn</div>';
                })
                ->addColumn('price',function ($product){
                    return number_format($product->price,0). ' VNĐ';
                })
                ->addIndexColumn()
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions','thumbnail','state'])
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
        $categories = Category::where(function ($query) use($keyword){
            $query->where('title','like',"%{$keyword}%")
                ->orWhere('note','like',"%{$keyword}%");
<<<<<<< HEAD
        })
            ->select(['id','title'])
            ->paginate(10);

        return response()->json($categories,200);
//
//
//       $keyword = $request->keyword;
//       $categories = Category::where(function ($query) use($keyword){
//                $query->where('title','like',"%{$keyword}%")
//                ->orWhere('note','like',"%{$keyword}%");
//            })
//           ->select(['id','title'])
//           ->paginate(10);
//
////       $categories->getCollection()->transform(function ($category){
////           $tmp = Category::where('parent_id','=',$category->id)->first();
////           if(!$tmp instanceof Category){
////               return $category;
////           }
////       });
//       return response()->json($categories,200);
=======
            })
           ->select(['id','title'])
           ->paginate(10);

        return response()->json($categories,200);
//       $categories->getCollection()->transform(function ($category){
//           $tmp = Category::where('parent_id','=',$category->id)->first();
//           if(!$tmp instanceof Category){
//               return $category;
//           }
//       });
>>>>>>> 88f7ada81fad527871a1385d56e35301d59a2ebc

    }

    public function uploadImage(Request $request){
        $type = intval($request->image_type);
        $imageData = null;
        switch ($type) {
            case 0:{
                    $imageData = $this->uploadSingleImage($request, 'description_image', 'product_description_images');
                    return response()->json($imageData, 200);
                    break;
                }
            case 1:{
                    $imageData = $this->uploadSingleImage($request,'qqfile','product_images');
                    $product = Product::find($request->product_id);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => 'storage/uploads/product_images/'.$imageData['image_name']
                    ]);
                    return response()->json(["success"=>true, "newUuid"=>$imageData],200);
                    break;
                }
        }
    }

    private function uploadSingleImage(Request $request,$fileName,$path){

        if($request->hasFile($fileName)){
            $image = $request->file($fileName);
            if($request->product_slug){
                $newName = time().'_'.$request->product_slug.'_'.$image->getClientOriginalName();
            } else
                $newName = time().'-'.$image->getClientOriginalName();

            if(File::exists(storage_path('app/public/uploads/'.$path.'/'.$newName)))
                $newName = rand(100,999).$newName;

            $image->move(storage_path('app/public/uploads/'.$path),$newName);
            return ['image_url'=>asset('storage/uploads/'.$path.'/'.$newName),'image_name'=>$newName];
        }
    }

    public function deleteImage(Request $request){
        $images = json_decode($request->images);
        $type = intval($request->type);

        $folder = null;
        switch ($type){
            case 0:{
                $folder = 'product_description_images';
                break;
            }
            case 1:{
                $folder = 'product_images';
                break;
            }
        }
        foreach ($images as $image) {
            $this->deleteSingleImage($folder,$image);
        }

        return response()->json(['code'=>1,'message'=>'Xóa thành công'],200);
    }

    private function deleteSingleImage($folder,$imageName){
        if(File::exists(storage_path('app/public/uploads/'.$folder.'/'.$imageName)))
            File::delete(storage_path('app/public/uploads/'.$folder.'/'.$imageName));
    }

    public function changeState($id){
        $product = Product::find($id);
        if($product instanceof Product){
            if($product->state == 'ACTIVE') {
                $product->state = 'INACTIVE';
                $product->save();
            } else{
                $product->state = 'ACTIVE';
                $product->save();
            }
            return response()->json(['code'=>1,'message'=>'Thay đổi trạng thái thành công!'],200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu phù hợp'],500);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->create_product_check_auto_code){
            $validator = Validator::make($request->all(),[
                'create_product_code'=>'required|string|unique:products,code|min:10',
            ],[],[
                'create_product_code'=>'Mã sản phẩm',
            ]);
            if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        }

        $validator = Validator::make($request->all(),[
            'create_product_name'=>'required|string|unique:products,title',
            'create_product_brand'=>'required|exists:brands,id',
            'create_product_category' => 'required',
            'create_product_price' => 'required|numeric',
            'create_product_discount' => 'nullable',
            'create_product_note' => 'required|string',
            'create_product_description' => 'required|string',
            'create_product_thumbnail' => 'required|file|mimes:jpeg,jpg,png,gif',
            'attributes' => 'required',
        ],[],[
            'create_product_name'=>'tên',
            'create_product_brand'=>'Thương hiệu',
            'create_product_category' => 'Loại sản phẩm',
            'create_product_price' => 'Giá',
            'create_product_discount' => 'Khuyến mãi',
            'create_product_note' => 'Ghi chú',
            'create_product_description' => 'Mô tả',
            'create_product_thumbnail' => 'Ảnh Thumbnail',
            'attributes' => 'Thông số kỹ thuật',
            'create_product_quantity' => 'Số lượng',
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        $all = $request->all();
        $attributes = json_decode($all['attributes']);
        $categories = json_decode($all['create_product_category']);

        $product = Product::create([
            'title' => $all['create_product_name'],
            'slug' => str_slug($all['create_product_name']),
            'description' => $all['create_product_description'],
            'note' => $all['create_product_note'],
            'price' => $all['create_product_price'],
            'discount' => $all['create_product_discount'],
            'quantity' => $all['create_product_quantity'],
            'brand_id' => $all['create_product_brand']
        ]);

        if($request->create_product_check_auto_code){
            $product->code = $this->generateCode($request);
        } else $product->code = $request->create_product_code;

        foreach ($attributes as $attribute){
            Attribute::create([
                'title'=>$attribute->title,
                'value' => $attribute->value,
                'product_id' => $product->id
            ]);
        }

        foreach ($categories as $category){
            $product->categories()->attach($category);
        }

        $imageData = $this->uploadSingleImage($request,'create_product_thumbnail','product_images');
        $product->thumbnail = 'storage/uploads/product_images/'.$imageData['image_name'];
        $product->save();

        return response()->json(['code'=>1,'data'=>$product],200);
    }

    private function generateCode(Request $request)
    {
        $productName = $request->create_product_name;
        if($productName){
            $productName = explode(' ',$productName);
            $temp = '';
            foreach($productName as $item){
                $temp .= strtoupper(str_slug(substr($item,0,1)));
            }
            $rand = (string)rand(0,99999999);
            if(strlen($rand) < 8){
                $tmp = '';
                for($i = 0; $i < 8-strlen($rand); $i++){
                    $tmp .= '0';
                }
                $rand = $tmp.$rand;
            }
            $temp = substr($temp,0,3).$rand;
            $check = Product::where('code',$temp)->count();
            if($check > 0)
                $this->generateCode($request);
            return $temp;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show',compact(['product']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    public function jsonEdit($id){

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
        $product = Product::find($id);

        if($product instanceof Product){
            $tmp = explode('/',$product->thumbnail);
            $thumbnailName = $tmp[count($tmp) -1];
            $this->deleteSingleImage('product_images',$thumbnailName);

            $images = $product->images;

            foreach ($images as $image){
                $tmp = explode('/',$image->path);
                $imageName = $tmp[count($tmp) -1];
                $this->deleteSingleImage('product_images',$imageName);
            }

            $product->categories()->detach();

            $product->delete();

            return response()->json(['code'=>1,'message'=>'Xóa thành công'],200);
        }
        return response()->json(['message'=>'Không tìm thấy dữ liệu phù hợp'],500);
    }
}
