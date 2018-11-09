<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AclController extends Controller
{
    public function index()
    {
        return view('acl.index');
    }

    public function allUsers()
    {
        try{
            $users = User::with(['role'])->get();
            return DataTables::of($users)
                ->addColumn('role', function($user){
                    return $user->role->display_name;
                })
                ->addColumn('actions',function($user){
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a class="dropdown-item" data-id="'.$user->id.'" href="#"><i class="ti-pencil"></i> Sửa</a>
                                </div>
                            </div>';
                })
                ->removeColumn('role_id')
                ->addIndexColumn()
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions'])
                ->make(true);
        }catch (\Exception $e){
            return [];
        }
    }

    public function allRoles()
    {
        try{
            return  DataTables::of(Role::all())
                ->addColumn('actions',function($role){
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-id="'.$role->id.'" 
                                       data-edit="'.route('acl.roles.edit',$role->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_edit_role" >
                                    <i class="ti-pencil"></i> Sửa</a>
                                    <a href="#" 
                                       class="dropdown-item delete" 
                                       data-delete="'.route('acl.roles.edit',$role->id).'" >
                                    <i class="ti-trash"></i> Xóa</a>
                                </div>
                            </div>';
                })
                ->addColumn('description',function($role){
                    return $role->description ?? 'N/A';
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

    public function editRole($id)
    {
        return Role::findOrFail($id);
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        if($role->delete())
            return response()->json(['message'=>'Xóa vai trò'.$role->display_name.' thành công.'],200);
        return response()->json(['message'=>'Đã xảy ra lỗi trong quá trình xử lý vui lòng kiểm tra lại.'],403);

    }

    public function storeRole(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required|unique:roles,name',
            'display_name'=>'required|string',
            'description'=>'nullable|string'
        ],[],[
            'name'=>'tên',
            'display_name'=>'tên hiển thị',
            'description'=>'mô tả'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        Role::create([
            'name'=>$request->name,
            'display_name'=>$request->display_name,
            'description'=>$request->description
        ]);
        return response()->json(['message'=>'Thêm mới vai trò thành công !'],200);
    }
    public function updateRole(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'edit_role_id'=>'required|exists:roles,id',
            'display_name'=>'required|string',
            'description'=>'nullable|string'
        ],[],[
            'edit_role_id'=>'vai trò',
            'display_name'=>'tên hiển thị',
            'description'=>'mô tả'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);
        $role = Role::findOrFail($request->edit_role_id);
        $role->update([
            'display_name'=>$request->display_name,
            'description'=>$request->description
        ]);
        return response()->json(['message'=>'Lưu thay đổi thành công !'],200);
    }

    public function allPermissions()
    {
        try{
            return  DataTables::of(Permission::all())
                ->addColumn('actions',function($permission){
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a class="dropdown-item" data-id="'.$permission->id.'" href="#"><i class="ti-pencil"></i> Sửa</a>
                                </div>
                            </div>';
                })
                ->addColumn('description',function($permission){
                    return $permission->description ?? 'N/A';
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
    public function storePermission(Request $request){

    }
}
