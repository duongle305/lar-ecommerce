<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return view('categories.index');
    }

    public function nestable()
    {
        $categories = Category::tree();
        return response()->json($categories,200);
    }
    private function prepareNestable($items, $parentId = null, $index = 0){
        foreach ($items as $item){
            $item = (object) $item;
            $index++;
            $category = Category::select(['id'])->find($item->id);
            $category->update([
                'parent_id'=>$parentId,
                'orders'=>$index,
            ]);
            if(isset($item->children))
                $this->prepareNestable($item->children,$item->id,$index);
        }
    }

    public function updateNestable(Request $request)
    {
        $items = $request->items;
        $this->prepareNestable($items);
        return response()->json(['message'=>'Cập nhập danh mục sản phẩm thành công.'],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required|string|max:255',
            'note'=>'nullable|string',
            'create_category_icons' => 'nullable|file|mimes:jpeg,jpg,png,gif',
            'create_category_icons_hover' => 'nullable|file|mimes:jpeg,jpg,png,gif'
        ],[],[
            'title'=>'tên danh mục',
            'note'=>'ghi chú',
            'create_category_icons' => 'Icon danh mục',
            'create_category_icons_hover' => 'Icon khi di chuột vào'
        ]);

        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

        $orderCategory = Category::whereNull('parent_id')
            ->orderBy('orders','DESC')->first();
        $order = 1;
        if($orderCategory instanceof Category){
            $order = $orderCategory->order;
        }

        $category = Category::create([
            'title'=>$request->title,
            'slug'=>str_slug($request->title),
            'orders' => intval($order) + 1,
            'note'=>$request->note
        ]);

        if($request->hasFile('create_category_icons') && $request->hasFile('create_category_icons_hover')){
            $createCategoryIcons = $request->file('create_category_icons');
            $createCategoryIconsHover = $request->file('create_category_icons_hover');

            $arrIcons = [
                $this->uploadImage($createCategoryIcons,$request->title)['path'],
                $this->uploadImage($createCategoryIconsHover,$request->title)['path']
            ];

            $category->menu_icons = json_encode($arrIcons);
            $category->save();
        }

        return response()->json(['message'=>'Thêm mới danh mục sản phẩm thành công.'],200);
    }

    public function uploadImage($file,$title){
        $newName = time().'-'.str_slug($title).$file->getClientOriginalName();

        if(File::exists(storage_path('app/public/uploads/menu_icons/'.$newName)))
            $newName = rand(100,999).$newName;

        $file->move(storage_path('app/public/uploads/menu_icons'),$newName);
        return ['image_name'=>$newName,'path'=>'storage/uploads/menu_icons/'.$newName];
    }

    private function deleteImage($path){
        if(File::exists(storage_path($path)))
            return File::delete(storage_path($path));
    }


    public function edit($id)
    {
        $category = Category::find($id);
        if(!$category instanceof Category) return response()->json(['errors'=>['not-found'=>['Không tìm thấy dữ liệu yêu cầu, vui lòng thử lại sau.']]],403);
        if($category->menu_icons){
            $icons = json_decode($category->menu_icons);
            if(strlen($icons[0]) > 0)
                $category->icon_default = asset($icons[0]);
            if(strlen($icons[1]) > 0)
                $category->icon_hover = asset($icons[1]);
        }
        return response()->json($category,200);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(),[
            'edit_category_id'=>'required|exists:categories,id',
            'edit_title'=>'required|string|max:255',
            'edit_note'=>'nullable|string',
            'edit_category_icon' => 'nullable|file|mimes:jpeg,jpg,png,gif',
            'edit_category_icon_hover' => 'nullable|file|mimes:jpeg,jpg,png,gif',
        ],[],[
            'edit_category_id'=>'danh mục',
            'edit_title'=>'tên danh mục',
            'edit_note'=>'ghi chú',
            'edit_category_icon' => 'Icon danh mục',
            'edit_category_icon_hover' => 'Icon di chuột',
        ]);

        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        $category = Category::find($request->edit_category_id);
        if(!$category instanceof Category) return response()->json(['errors'=>['not-found'=>['Không thể xử lý yêu cầu, vui lòng thử lại sau.']]],403);
        $category->update([
            'title'=>$request->edit_title,
            'slug'=>str_slug($request->edit_title),
            'note'=>$request->edit_note,
        ]);

        if($request->hasFile('edit_category_icon')){
            $categoryIcon = $request->file('edit_category_icon');
            if(empty($category->menu_icons)){
                $arrIcons = [$this->uploadImage($categoryIcon,$category->title)['path'],''];
                $category->menu_icons = json_encode($arrIcons);
                $category->save();
            } else {
                $icons = json_decode($category->menu_icons);
                if(strlen($icons[0]) == 0){
                    $icons[0] = $this->uploadImage($categoryIcon,$category->title)['path'];
                } else{
                    $tmp = explode('/',$icons[0]);
                    $this->deleteImage('app/public/uploads/menu_icons/'.$tmp[count($tmp)-1]);
                    $icons[0] = $this->uploadImage($categoryIcon,$category->title)['path'];
                }
                $category->menu_icons = json_encode($icons);
                $category->save();
            }
        }

        if($request->hasFile('edit_category_icon_hover')){
            $categoryIconHover = $request->file('edit_category_icon_hover');
            if(empty($category->menu_icons)){
                $arrIcons = ['',$this->uploadImage($categoryIconHover,$category->title)['path']];
                $category->menu_icons = json_encode($arrIcons);
                $category->save();
            } else {
                $icons = json_decode($category->menu_icons);
                if(strlen($icons[1]) == 0){
                    $icons[1] = $this->uploadImage($categoryIconHover,$category->title)['path'];
                } else{
                    $tmp = explode('/',$icons[1]);
                    $this->deleteImage('app/public/uploads/menu_icons/'.$tmp[count($tmp)-1]);
                    $icons[1] = $this->uploadImage($categoryIconHover,$category->title)['path'];
                }
                $category->menu_icons = json_encode($icons);
                $category->save();
            }
        }
        return response()->json(['message'=>'Cập nhật thông tin danh mục sản phẩm thành công.'],200);
    }
    public function delete($id){
        $category = Category::find($id);
        if(!$category instanceof Category) return response()->json(['errors'=>['not-found'=>['Không thể xử lý yêu cầu, vui lòng thử lại sau.']]],403);
        if($category->children->count() > 0){
            return response()->json(['code'=>1,'message'=>'Danh mục đang có các mục con, vui lòng di chuyển mục con sang mục cha khác hoặc xóa hết các mục con trước'],200);
        } else {
            if(!empty($category->menu_icons)){
                $icons = json_decode($category->menu_icons);
                if(strlen($icons[0]) > 0){
                    $tmp = explode('/',$icons[0]);
                    $this->deleteImage('app/public/uploads/menu_icons/'.$tmp[count($tmp)-1]);
                }
                if(strlen($icons[1]) > 0){
                    $tmp = explode('/',$icons[1]);
                    $this->deleteImage('app/public/uploads/menu_icons/'.$tmp[count($tmp)-1]);
                }
            }
            $category->delete();
            return response()->json(['message'=>'Xóa danh mục sản phẩm thành công.'],200);
        }
    }
}
