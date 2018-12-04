<?php

namespace App\Http\Controllers;

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
        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required',
        ],[],[

        ]);
    }

    public function edit($id)
    {
        
    }

    public function update(Request $request)
    {

    }
    public function delete($id){

    }
}
