<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
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
                                       data-edit="'.route('acl.roles.edit',$brand->id).'" 
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
                    return $brand->description ?? 'N/A';
                })
                ->addColumn('logo',function ($brand){
                    return $brand->logo ? '' : '<div class="text-center"><img style="width: 60px;height: 60px;" class="rounded" src="'.asset('storage/uploads/brand_logo/default_logo.png').'"/></div>';
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
