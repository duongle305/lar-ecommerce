<?php

namespace App\Http\Controllers;

use App\Menu;
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
            return DataTables::of(Menu::all())
                ->addColumn('actions',function($menu){
                    return '<div class="dropdown dropup">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-id="'.$menu->id.'" 
                                       data-edit="'.route('menu-builders.menus.edit',$menu->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_edit_menu" >
                                    <i class="ti-pencil"></i> Sửa</a>
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
        return response()->json(['message'=>'Thêm mới menu thành công !'],200);
    }

    public function editMenu($id)
    {
        return Menu::findOrFail($id);
    }

    public function updateMenu(Request $request)
    {
        return $request->all();
    }
        
}
