<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AclController extends Controller
{
    public function index()
    {
        return view('acl.index');
    }

    public function allUser()
    {
        $users = User::with(['role'])->get();
        try{
            return DataTables::of($users)
                ->addColumn('role', function($user){
                    return $user->role->display_name;
                })
                ->addColumn('actions',function($user){
                    return '<button type="button" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#modal_edit"><i class="ti-pencil"></i></button>
                            <button type="button" class="btn btn-danger waves-effect waves-light"><i class="ti-trash"></i></button>';
                })
                ->addIndexColumn()
                ->removeColumn('role_id')
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->rawColumns(['actions'])
                ->make(true);
        }catch (\Exception $e){}
    }
}
