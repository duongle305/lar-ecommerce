@extends('layouts.app')
@section('dashboard_active','active')
@section('pageCSS')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs float-xs-left">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab1">Danh mục</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab2">Profile</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <h5 class="mb-1">Danh mục</h5>
                                    </div>
                                    <div class="col-lg-6 text-xs-right">
                                        <button class="btn btn-success" data-toggle="modal" data-target="#modal_create_user">Thêm mới</button>
                                        <button class="btn btn-primary" id="btn-reload-users" data-href="{{ route('acl.users') }}">Tải lại</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="table_users" class="table table-striped table-bordered" style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên</th>
                                            <th>E-mail</th>
                                            <th>Vai trò</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div id="tab2" class="tab-pane">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pageJS')
@endsection