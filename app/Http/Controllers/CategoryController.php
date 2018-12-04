<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
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
        ],[],[
            'title'=>'tên danh mục',
            'note'=>'ghi chú',
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        Category::create([
            'title'=>$request->title,
            'slug'=>str_slug($request->title),
            'note'=>$request->note,
        ]);
        return response()->json(['message'=>'Thêm mới danh mục sản phẩm thành công.'],200);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        if(!$category instanceof Category) return response()->json(['errors'=>['not-found'=>['Không tìm thấy dữ liệu yêu cầu, vui lòng thử lại sau.']]],403);
        return response()->json($category,200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'edit_category_id'=>'required|exists:categories,id',
            'edit_title'=>'required|string|max:255',
            'edit_note'=>'nullable|string',
        ],[],[
            'edit_category_id'=>'danh mục',
            'edit_title'=>'tên danh mục',
            'edit_note'=>'ghi chú',
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        $category = Category::find($request->edit_category_id);
        if(!$category instanceof Category) return response()->json(['errors'=>['not-found'=>['Không thể xử lý yêu cầu, vui lòng thử lại sau.']]],403);
        $category->update([
            'title'=>$request->edit_title,
            'slug'=>str_slug($request->edit_title),
            'note'=>$request->edit_note,
        ]);
        return response()->json(['message'=>'Cập nhật thông tin danh mục sản phẩm thành công.'],200);
    }
    public function delete($id){
        $category = Category::find($id);
        if(!$category instanceof Category) return response()->json(['errors'=>['not-found'=>['Không thể xử lý yêu cầu, vui lòng thử lại sau.']]],403);
        $category->delete();
        return response()->json(['message'=>'Xóa danh mục sản phẩm thành công.'],200);
    }
}
