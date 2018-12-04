@extends('layouts.app')
@section('acl_active','active')
@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/css/dropify.min.css') }}">
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
                                        @if(auth()->user()->hasPermission('create_acl'))
                                        <button class="btn btn-success" data-toggle="modal"
                                                data-target="#modal_create_user">Thêm mới
                                        </button>
                                        @endif
                                        <button class="btn btn-primary" id="btn-reload-users"
                                                data-href="{{ route('acl.users') }}">Tải lại
                                        </button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="table_users" class="table table-striped table-bordered"
                                           style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên</th>
                                            <th>E-mail</th>
                                            <th>Vai trò</th>
                                            <th>Avatar</th>
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
                                                @if(auth()->user()->hasPermission('create_acl'))
                                                <button class="btn btn-success" data-toggle="modal"
                                                        data-target="#modal_create_role">Thêm mới
                                                </button>
                                                @endif
                                                <button class="btn btn-primary" id="btn-reload-roles"
                                                        data-href="{{ route('acl.roles') }}">Tải lại
                                                </button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="table_roles" class="table table-striped table-bordered"
                                                   style="width: 100%;">
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
                                                @if(auth()->user()->hasPermission('create_acl'))
                                                <button class="btn btn-success" data-toggle="modal"
                                                        data-target="#modal_create_permission">Thêm mới
                                                </button>
                                                @endif
                                                <button class="btn btn-primary" id="btn-reload-permissions"
                                                        data-href="{{ route('acl.permissions') }}">Tải lại
                                                </button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="table_permissions" class="table table-striped table-bordered"
                                                   style="width: 100%;">
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

    <!-- Modal create user -->
    <div id="modal_create_user" class="modal animated bounceInDown" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_create_user" action="{{ route('acl.users.store') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Thêm mới nhân viên</h5>
                    </div>
                    <div class="modal-body">
                        <h6>Thông tin bắt buộc</h6>
                        <div class="row mt-20">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_user_name">Họ & Tên <span class="text-danger">*</span></label>
                                    <input class="form-control" name="create_user_name" id="create_user_name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_user_email">Email <span class="text-danger">*</span></label>
                                    <input class="form-control" name="create_user_email" id="create_user_email">
                                    <small class="form-text text-muted">Email phải không trùng với những email đã được sử dụng bởi các nhân viện khác
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_user_gender">Giới tính <span class="text-danger">*</span></label>
                                    <select class="form-control" id="create_user_gender" name="create_user_gender">
                                        <option value="M">Nam</option>
                                        <option value="F">Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_user_birthday">Ngày sinh</label>
                                    <input class="form-control" data-mask="99/99/9999" placeholder="mm/dd/yyyy" id="create_user_birthday" name="create_user_birthday">
                                </div>
                            </div>
                        </div>
                        <h6>Thông tin thêm</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="create_user_check_add_address" name="create_user_check_add_address">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Thêm địa chỉ</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row add-address">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="create_user_province" class="col-md-12">Tỉnh/Thành phố</label>
                                    <select data-placeholder="Chọn Tỉnh/Thành phố"  name="create_user_province" id="create_user_province" title="Chọn Tỉnh/Thành phố"></select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="create_user_district" class="col-md-12">Quận/Huyện</label>
                                    <select data-placeholder="Chọn Quận/Huyện" title="Chọn Quận/Huyện" name="create_user_district" id="create_user_district"></select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="create_user_ward" class="col-md-12">Phường/Xã</label>
                                    <select data-placeholder="Chọn Phường/Xã" title="Chọn Phường/Xã" name="create_user_ward" id="create_user_ward"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row add-address">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="create_user_house_street">Số nhà, tên đường</label>
                                    <textarea class="form-control" id="create_user_house_street" name="create_user_house_street" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted m-b-30 font-13">Mật khẩu mặc định cho tài khoản này là <b>"password"</b></p>
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="create_user_check_change_pass" name="create_user_check_change_pass">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Đổi mật khẩu</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row add-pass">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="create_user_password">Mật khẩu</label>
                                    <input class="form-control" type="password" name="create_user_password" id="create_user_password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="create_user_confirm_password">Nhập lại mật khẩu</label>
                                    <input class="form-control" type="password" name="create_user_confirm_password" id="create_user_confirm_password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="create_user_check_avatar" name="create_user_check_avatar">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Thêm ảnh đại diện</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row add-avatar">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="create_user_avatar">Ảnh đại diện</label>
                                    <input type="file" id="create_user_avatar" name="create_user_avatar" class="dropify" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ti-plus"></i> {{ __('Hoàn thành') }}
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
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
                                    <small class="form-text text-muted">Tên phải là chữ thường không dấu vd: <code>administrator</code>
                                    </small>
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
                        <button type="submit" class="btn btn-primary"><i class="ti-plus"></i> {{ __('Thêm mới') }}
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="ti-close"></i> {{ __('Đóng') }}</button>
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
                        <button type="submit" class="btn btn-primary"><i class="ti-check"></i> {{ __('Lưu thay đổi') }}
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal create permission -->
    <div id="modal_create_permission" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_create_permission" action="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Tạo mới Quyền</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-20">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="custom-control custom-radio">
                                        <input id="radio1" name="radio" type="radio" value="basic" class="custom-control-input" checked v-model="type">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Cơ bản</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="radio2" name="radio" type="radio" value="advance" class="custom-control-input" v-model="type">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Nâng cao</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- basic -->
                        <div class="row" v-if="type === 'basic'">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_permission_name">Tên</label>
                                    <input class="form-control" name="name" id="create_permission_name" readonly="readonly" :value="nameToSlug">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_permission_display_name">Tên hiển thị</label>
                                    <input class="form-control" name="display_name" id="create_permission_display_name" v-model="name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group" v-if="type === 'basic'">
                            <label for="create_permission_description">Mô rả</label>
                            <textarea class="form-control" name="description" id="create_permission_description" rows="3" v-model="description"></textarea>
                        </div>
                        <!-- end basic -->
                        <!-- advance -->
                        <div class="row" v-if="type === 'advance'">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên hiển thị</label>
                                        <input type="text" class="form-control" id="create_permission_display_name" placeholder="Tên hiển thị" v-model="name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" value="create" class="custom-control-input" v-model="permissionTypes" checked>
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Create</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" value="update" class="custom-control-input" v-model="permissionTypes">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Update</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" value="read" class="custom-control-input" v-model="permissionTypes">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Read</span>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" value="delete" class="custom-control-input" v-model="permissionTypes">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Delete</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <label for="exampleInputEmail1">Các quyền sẽ được tạo: </label>
                                <table class="table mb-md-0">
                                    <thead>
                                    <tr>
                                        <th>Tên</th>
                                        <th>Tên hiển thị</th>
                                        <th>Mô tả</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(nameInput,index) in nameInputs">
                                        <td>@{{ nameInput }}</td>
                                        <td>@{{ displayNameInputs[index] }}</td>
                                        <td>@{{ descriptionInputs[index] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- end advance -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" @click="submit" href="{{ route('acl.permissions.create') }}"><i class="ti-plus"></i> {{ __('Hoàn thành') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Modal edit permission -->
    <div id="modal_edit_permission" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_edit_permission" action="{{ route('acl.permissions.update') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Cập nhật quyền</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_permission_id" id="edit_permission_id">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_permission_name">Tên</label>
                                    <input class="form-control" name="edit_permission_name" id="edit_permission_name" readonly="readonly">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_permission_display_name">Tên hiển thị</label>
                                    <input class="form-control" name="edit_permission_display_name" id="edit_permission_display_name">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="create_permission_description">Mô rả</label>
                            <textarea class="form-control" name="edit_permission_description" id="edit_permission_description" rows="3"></textarea>
                        </div>
                    </div>
                    <!-- end advance -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" @click="submit" href="{{ route('acl.permissions.create') }}"><i class="ti-plus"></i> {{ __('Hoàn thành') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/JSZip/jszip.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/pdfmake/build/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/pdfmake/build/vfs_fonts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-inputmask/bootstrap-inputmask.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dropify/dist/js/dropify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/acl.js') }}"></script>
@endsection

