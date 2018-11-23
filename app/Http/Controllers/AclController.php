<?php

namespace App\Http\Controllers;

use App\District;
use App\Permission;
use App\Province;
use App\Role;
use App\User;
use App\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function PHPSTORM_META\elementType;
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

    public function getProvinces(Request $request){
        $provinces = Province::
            where('name','like',"%{$request->keyword}%")
            ->paginate(10);
        return response()->json($provinces,200);
    }

    public function getDistricts(Request $request){
        $provinceId= $request->province;
        $keyWord = $request->keyword;
        $districts = District::
            where('province_id',$provinceId)
            ->where('name','like',"%{$keyWord}%")
            ->paginate(10);
        return response()->json($districts,200);
    }

    public function getWards(Request $request){
        $districtId =$request->district;
        $keyWord = $request->keyword;
        $wards = Ward::
            where('district_id',$districtId)
            ->where('name','like',"%{$keyWord}%")
            ->paginate(10);
        return response()->json($wards,200);
    }

    public function storeUser(Request $request){
        $validator = Validator::make($request->all(),[
            'create_user_name'=>'required|string',
            'create_user_email'=>'required|email|unique:users,email',
            'create_user_gender'=>'required|string',
            'create_user_birthday' =>'nullable',
        ],[],[
            'create_user_name'=>'Tên',
            'create_user_email'=>'Email',
            'create_user_gender'=>'Giới tính',
            'create_user_birthday' => 'Ngày sinh'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

        $user = new User();
        $user->name = $request->create_user_name;
        $user->email = $request->create_user_email;
        $user->gender = $request->create_user_gender;
        if($request->create_user_birthday){
            $user->birthday = Carbon::createFromFormat('d/m/Y', $request->create_user_birthday)->toDateString();
        }

        if($request->create_user_check_add_address){
            $validator = Validator::make($request->all(),[
                'create_user_province'=>'required|exists:provinces,id',
                'create_user_district'=>'required|exists:districts,id',
                'create_user_ward'=>'required|exists:wards,id',
                'create_user_house_street' =>'required|string',
            ],[],[
                'create_user_province'=>'Tỉnh/Thành phố',
                'create_user_district'=>'Quận/Huyện',
                'create_user_ward'=>'Phường/Xã',
                'create_user_house_street' => 'Số nhà, tên đường'
            ]);
            if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

            $user->address = $request->create_user_house_street.', '.$request->ward_text.', '.$request->district_text.', '.$request->province_text;
        }

        if($request->create_user_check_change_pass){
            $validator = Validator::make($request->all(),[
                'create_user_password'=>'required|min:6|same:create_user_confirm_password',
                'create_user_confirm_password'=>'required|min:6',
            ],[],[
                'create_user_password'=>'Mật khẩu',
                'create_user_confirm_password'=>'Nhập lại mật khẩu',
            ]);
            if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

            $user->password = Hash::make($request->create_user_password);

        } else{
            $user->password = Hash::make('password');
        }
        $user->role_id = 2;
        $user->state = 'ACTIVE';
        $user->save();

        return response()->json(['code' => 1,'message'=>'Tạo mới nhân viên thành công!'],200);
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
                                       data-delete="'.route('acl.roles.delete',$role->id).'" >
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
            return response()->json(['message'=>'Xóa vai trò <strong>'.$role->display_name.'</strong> thành công.'],200);
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
        return response()->json(['message'=>'Cập nhật vai trò thành công.'],200);
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
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-id="'.$permission->id.'" 
                                       data-edit="'.route('acl.permissions.edit',$permission->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_edit_permission" >
                                        <i class="ti-pencil"></i> Sửa</a>
                                    <a href="#" 
                                       class="dropdown-item permission-delete" 
                                       data-id="'.$permission->id.'" 
                                       data-delete="'.route('acl.permissions.delete',$permission->id).'">
                                        <i class="ti-close"></i> Xóa</a>
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
        $validator = Validator::make($request->all(),[
            'permissions'=>'required',
            'permissions.*.name' => 'required|string',
            'permissions.*.display_name' => 'required|string',
            'permissions.*.description' => 'required|string'
        ],[],[
            'permissions'=>'Danh sách quyền',
            'permissions.*.name' => 'Tên',
            'permissions.*.display_name' => 'Tên hiển thị',
            'permissions.*.description' => 'Mô tả'
        ]);
        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

        $permissions =json_decode($request->permissions);
        foreach ($permissions as $permission){
            Permission::create([
                'name' => $permission->name,
                'display_name' => $permission->display_name,
                'description' => $permission->description
            ]);
        }
        return response()->json(['code'=> 1,'message'=>'Tạo mới quyền thành công'],200);
    }
    public function editPermission($id){
        return Permission::find($id);
    }
    public function updatePermission(Request $request){
        $validator = Validator::make($request->all(),[
            'edit_permission_id'=>'required|exists:permissions,id',
            'edit_permission_display_name'=>'required|string',
            'edit_permission_description'=>'nullable|string'
        ],[],[
            'edit_permission_id'=>'ID Quyền',
            'edit_permission_display_name'=>'Tên hiển thị',
            'edit_permission_description'=>'Mô tả'
        ]);

        if($validator->fails()) return response()->json(['errors'=>$validator->errors()],403);

        $permission = Permission::find($request->edit_permission_id);
        $permission->update([
            'name' => $request->edit_permission_name,
            'display_name' => $request->edit_permission_display_name,
            'description' => $request->edit_permission_description
        ]);

        return response()->json(['message'=> 'Cập nhật quyền thành công!',200]);
    }
    public function deletePermission($id){
        $permission = Permission::find($id);
        if($permission instanceof Permission){
            $permission->delete();
            return response()->json(['message'=>'Xóa quyền thành công!'],200);
        }
        return response()->json(['error'=>'Không tìm thấy dữ liệu phù hợp, không thể xóa!'],403);
    }
}
