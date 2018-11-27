<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MenuController extends Controller
{
    public function index(){
        return view('menu-builders.index');
    }

    public function allMenus()
    {
        try{
            return DataTables::of(Menu::select(['id','name','note'])->get())
                ->addColumn('actions',function($menu){
                    return '<div class="dropdown dropup">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="'.route('menu-builders.menu-items.index',$menu->id).'" 
                                       class="dropdown-item">
                                    <i class="ti-menu"></i> Builder</a>
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-id="'.$menu->id.'" 
                                       data-edit="'.route('menu-builders.menus.edit',$menu->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_edit_menu" >
                                    <i class="ti-pencil"></i> Sửa</a>
                                    <a href="#" 
                                       class="dropdown-item delete" 
                                       data-id="'.$menu->id.'" 
                                       data-delete="'.route('menu-builders.menus.delete',$menu->id).'" >
                                    <i class="ti-trash"></i> Xóa</a>
                                </div>
                            </div>';
                })
                ->addColumn('note',function($menu){
                    return $menu->note ?? 'N/A';
                })
                ->addIndexColumn()
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions'])
                ->make(true);
        }catch (\Exception $e){ return response()->json([],200); }
    }

    public function storeMenu(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|unique:menus,name',
            'note'=>'nullable|string|max:255',
        ],[],[
            'name'=>'tên',
            'note'=>'ghi chú'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        $all = $request->only(['name','note']);
        Menu::create($all);
        return response()->json(['message'=>'Thêm mới menu thành công.'],200);
    }

    public function editMenu($id)
    {
        return Menu::findOrFail($id);
    }

    public function updateMenu(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'menu_id'=>'required|exists:menus,id',
            'name'=>'required|string',
            'note'=>'nullable|string|max:255',
        ],[
            'menu_id.required'=>'Đã xảy ra lỗi trong quá trình xử lý.',
            'menu_id.exists'=>'Đã xảy ra lỗi trong quá trình xử lý.'
        ],[
            'menu_id'=>'menu',
            'name'=>'tên',
            'note'=>'ghi chú'
        ]);
        $menu = Menu::find($request->menu_id);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        $menu->update($request->only(['name','note']));
        return response()->json(['message'=>'Cập nhật menu thành công.'],200);
    }

    public function deleteMenu($id)
    {
        $menu = Menu::findOrFail($id);
        if($menu->delete())
            return response()->json(['message'=>'Xóa menu thành công.'],200);
        return response()->json(['message'=>'Đã xảy ra lỗi trong quá trình xử lý vui lòng kiểm tra lại.'],403);
    }

    public function menuItem($id){

        return view('menu-builders.menu-item');
    }

    public function storeMenuItem(Request $request)
    {
        
    }
    public function nestable($id){
        $menu = Menu::select('id')->findOrFail($id);
        return response()->json($menu->menuItem(),200);
    }

    public function nestableUpdate(Request $request)
    {
        $items = $request->items;
        $this->prepareNestable($items);
        return response()->json(['message'=>'Cập nhập menu item thành công.'],200);
    }
    private function prepareNestable($items, $parentId = null, $index = 0){
        foreach ($items as $item){
            $item = (object) $item;
            $index++;
            $menuItem = MenuItem::select(['id'])->find($item->id);
            $menuItem->update([
                'parent_id'=>$parentId,
                'orders'=>$index,
            ]);
            if(isset($item->children))
                $this->prepareNestable($item->children,$item->id,$index);
        }
    }
}
