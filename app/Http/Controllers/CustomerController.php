<?php

namespace App\Http\Controllers;

use App\Customer;
use App\District;
use App\Province;
use App\Ward;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customers.index');
    }


    public function allCustomers(){
        try{
            return  DataTables::of(Customer::all())
                ->addColumn('actions',function($customer){
                    return '<div class="dropdown dropup float-xs-right">
                                <a class="btn btn-secondary waves-effect waves-light dropdown-toggle" href="#" data-toggle="dropdown">
                                    <i class="ti-menu"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right animated flipInX">
                                    <a href="#" 
                                       class="dropdown-item" 
                                       data-view="'.route('customers.show',$customer->id).'" 
                                       data-toggle="modal" 
                                       data-target="#modal_view_customer" >
                                    <i class="ti-info"></i> Thông tin</a>
                                </div>
                            </div>';
                })
                ->addColumn('phone',function ($customer){
                    return ($customer->phone) ? $customer->phone : 'N/A';
                })
                ->addColumn('avatar',function ($customer){
                    return '<div class="text-center"><img style="width: 60px;height: 60px;" class="rounded" src="'.asset('storage/uploads/customer_avatar/'.$customer->avatar).'"/></div>';

                })
                ->addIndexColumn()
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions','avatar'])
                ->make(true);
        }catch (\Exception $e){
            return response()->json([],200);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function getProvinces(Request $request){
        $keyword = $request->keyword;
        $provinces = Province::where('name','like',"%{$keyword}%")
            ->paginate(10);
        return response()->json($provinces,200);
    }

    public function getDistricts(Request $request){
        $keyword = $request->keyword;
        $provenceID = $request->province_id;

        $districts = District::where('name','like',"%{$keyword}%")
            ->where('province_id','=',$provenceID)
            ->paginate(10);

        return response()->json($districts,200);
    }

    public function getWards(Request $request){
        $keyword = $request->keyword;
        $districtID = $request->district_id;
        $wards = Ward::where('name','like',"%{$keyword}%")
            ->where('district_id','=',$districtID)
            ->paginate(10);

        return response()->json($wards,200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'create_customer_name' => 'required|string',
            'create_customer_email' => 'required|email|unique:customers,email',
            'create_customer_gender' => 'required|string',
            'create_customer_birthday' => 'string|nullable'
        ],[],[
            'create_customer_name' => 'Họ & Tên',
            'create_customer_email' => 'Email',
            'create_customer_gender' => 'Giới tính',
            'create_customer_birthday' => 'Ngày sinh'
        ]);
        if($validate->fails()) return response()->json(['code'=>0,'errors'=>$validate->errors()],403);

        $customer = new Customer();
        $customer->name = $request->create_customer_name;
        $customer->email = $request->create_customer_email;
        $customer->gender = $request->create_customer_gender;
        (!empty($request->create_customer_birthday)) ?
            $customer->birthday = Carbon::createFromFormat('d/m/Y', $request->create_customer_birthday)->toDateString() :
            $customer->birthday = null;

        if($request->create_customer_check_add_address){
            $validate = Validator::make($request->all(),[
                'create_customer_province' => 'required|exists:provinces,id',
                'create_customer_district' => 'required|exists:districts,id',
                'create_customer_ward' => 'required|exists:wards,id',
                'create_customer_house_street' => 'required|string'
            ],[],[
                'create_customer_province' => 'Tỉnh/Thành phố',
                'create_customer_district' => 'Quận/Huyện',
                'create_customer_ward' => 'Phường/Xã',
                'create_customer_house_street' => 'Số nhà, tên đường'
            ]);

            if($validate->fails()) return response()->json(['code'=>0,'errors'=>$validate->errors()],403);

            $customer->address = "{$request->create_customer_house_street}, {$request->ward_text}, {$request->district_text}, {$request->province_text}";
        }

        if($request->create_customer_check_change_pass){
            $validate = Validator::make($request->all(),[
                'create_customer_password' => 'required|string|min:6',
                'create_customer_confirm_password' => 'required|string|min:6|same:create_customer_password'
            ],[],[
                'create_customer_password' => 'Mật khẩu',
                'create_customer_confirm_password' => 'Nhập lại mật khẩu'
            ]);
            if($validate->fails()) return response()->json(['code'=>0,'errors'=>$validate->errors()],403);
            $customer->password = \Hash::make($request->create_customer_password);
        } else $customer->password = \Hash::make('password');

        if($request->create_customer_check_add_avatar){
            $validate = Validator::make($request->all(),[
                'create_customer_avatar' => 'required|mimes:jpg,jpeg,png,gif|max:5120',
            ],[],[
                'create_customer_avatar' => 'Ảnh đại diện',
            ]);
            if($validate->fails()) return response()->json(['code'=>0,'errors'=>$validate->errors()],403);
            $time = time();
            $customerName = str_slug($request->create_customer_name);
            $avatar = $request->file('create_customer_avatar');
            $newName = "{$time}-{$customerName}.{$avatar->getClientOriginalExtension()}";
            $avatar->move(storage_path('app/public/uploads/customer_avatar'),$newName);
            $customer->avatar = $newName;
        }

        $customer->state = 'ACTIVE';
        $customer->save();
        return response()->json(['code'=>1,'message'=>'Thêm mới khách hàng thành công!'],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer  = Customer::find($id);

        if($customer instanceof Customer){
            $customer->birthday ?
                $customer->birthday = date('d/m/Y',strtotime($customer->birthday)) :
                $customer->birthday = 'N/A';
            $customer->address ?? $customer->address = 'N/A';
            $customer->phone ?? $customer->phone = 'N/A';
            $customer->company ?? $customer->company = 'N/A';
            $customer->country ?? $customer->country = 'N/A';
            $customer->zip_code ?? $customer->zip_code = 'N/A';
            $customer->avatar ? $customer->avatar = '<img src="http://lar-ecommerce.local/storage/uploads/customer_avatar/'.$customer->avatar.'" class="img-fluid img-thumbnail" alt="">' :
                $customer->avatar = '<img src="http://lar-ecommerce.local/storage/uploads/customer_avatar/customer_default.png" class="img-fluid img-thumbnail" alt="">';
            return response()->json(['code'=>1,'data'=>$customer,],200);
        }
        return response()->json(['code'=>0,'error'=>'Có lỗi xảy ra, liên hệ System Admin'],200);
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
