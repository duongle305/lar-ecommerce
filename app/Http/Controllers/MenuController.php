<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
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
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-id="'.$menu->id.'" 
                                       data-edit="" 
                                       data-toggle="modal" 
                                       data-target="#modal_edit_role" >
                                    <i class="ti-pencil"></i> Sửa</a>
                                </div>
                            </div>';
                })
                ->addIndexColumn()
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions'])
                ->make(true);
        }catch (\Exception $e){ return response()->json([],200); }
    }

        
}
