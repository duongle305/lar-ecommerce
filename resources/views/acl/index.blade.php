@extends('layouts.app')
@section('acl_active','active')
@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs float-xs-left">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab1">Nhân viên</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tab2">Vai trò & Quyền</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <h5 class="mb-1">Nhân viên</h5>
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
                                            <th style="width: 60px;">Actions</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                            <div id="tab2" class="tab-pane">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row mb-2">
                                            <div class="col-lg-6">
                                                <h5 class="mb-2">Vai trò</h5>
                                            </div>
                                            <div class="col-lg-6 text-xs-right">
                                                <button class="btn btn-success" data-toggle="modal" data-target="#modal_create_role">Thêm mới</button>
                                                <button class="btn btn-primary" id="btn-reload-roles" data-href="{{ route('acl.roles') }}">Tải lại</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="table_roles" class="table table-striped table-bordered" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tên</th>
                                                    <th>Tên hiển thị</th>
                                                    <th>Mô tả</th>
                                                    <th style="width: 60px;">Actions</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row mb-2">
                                            <div class="col-lg-6">
                                                <h5 class="mb-2">Quyền</h5>
                                            </div>
                                            <div class="col-lg-6 text-xs-right">
                                                <button class="btn btn-success" data-toggle="modal" data-target="#modal_create_permission">Thêm mới</button>
                                                <button class="btn btn-primary" id="btn-reload-permissions" data-href="{{ route('acl.permissions') }}">Tải lại</button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="table_permissions" class="table table-striped table-bordered" style="width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tên</th>
                                                    <th>Tên hiển thị</th>
                                                    <th>Mô tả</th>
                                                    <th style="width: 60px;">Actions</th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal create role -->
    <div id="modal_create_role" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_create_role" action="{{ route('acl.roles.store') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Sửa</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_role_name">Tên <span class="text-danger">*</span></label>
                                    <input class="form-control" name="name" id="create_role_name">
                                    <small class="form-text text-muted">Tên phải là chữ thường không dấu vd: <code>administrator</code></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_role_display_name">Tên hiển thị <span class="text-danger">*</span></label>
                                    <input class="form-control" name="display_name" id="create_role_display_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="create_role_description">Mô tả</label>
                            <textarea class="form-control" name="description" id="create_role_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ti-plus"></i> {{ __('Thêm mới') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal edit role -->
    <div id="modal_edit_role" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_edit_role" action="{{ route('acl.roles.update') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Sửa</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_role_id" id="edit_role_id">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_role_name">Tên <span class="text-danger">*</span></label>
                                    <input class="form-control bg-faded" id="edit_role_name" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="edit_role_display_name">Tên hiển thị <span class="text-danger">*</span></label>
                                    <input class="form-control" name="display_name" id="edit_role_display_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_role_description">Mô tả</label>
                            <textarea class="form-control" name="description" id="edit_role_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ti-check"></i> {{ __('Lưu thay đổi') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal create permission -->
    <div id="modal_create_permission" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_create_role" action="{{ route('acl.roles.store') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Tạo mới Quyền</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_role_name">Tên</label>
                                    <input class="form-control" name="name" id="create_role_name">
                                    <small class="form-text text-muted">Tên phải là chữ thường không dấu vd: <code>administrator</code></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_role_display_name">Tên hiển thị</label>
                                    <input class="form-control" name="display_name" id="create_role_display_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="create_role_description">Mô rả</label>
                            <textarea class="form-control" name="description" id="create_role_description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ti-plus"></i> {{ __('Thêm mới') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/JSZip/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/pdfmake/build/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/pdfmake/build/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/acl.js') }}"></script>
@endsection

