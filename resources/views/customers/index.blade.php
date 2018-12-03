@extends('layouts.app')
{{--@section('dashboard_active','active')--}}
@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-daterangepicker/daterangepicker.css') }}">

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs float-xs-left">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab1">Danh mục khách hàng</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <h5 class="mb-2">Danh mục khách hàng</h5>
                                    </div>
                                    <div class="col-lg-6 text-xs-right">
                                        <button class="btn btn-success" data-toggle="modal"
                                                data-target="#modal_create_customer">Thêm mới
                                        </button>
                                        <button class="btn btn-primary" id="btn-reload-customers"
                                                data-href="{{ route('customers.all-customers') }}">Tải lại
                                        </button>
                                    </div>
                                </div>
                                <table id="table_customers" class="table table-striped table-bordered" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Số ĐT</th>
                                        <th>Avatar</th>
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

    <!-- modal create customer -->
    <div id="modal_create_customer" class="modal animated bounceInDown" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_create_customer" action="{{ route('customers.store') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Thêm mới khách hàng</h5>
                    </div>
                    <div class="modal-body">
                        <h6>Thông tin bắt buộc</h6>
                        <div class="row mt-20">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_customer_name">Họ & Tên <span class="text-danger">*</span></label>
                                    <input class="form-control" name="create_customer_name" id="create_customer_name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                        <label for="create_customer_email">Email <span class="text-danger">*</span></label>
                                        <input class="form-control" name="create_customer_email" id="create_customer_email">
                                    <small class="form-text text-muted">Email phải không trùng với những email đã được sử dụng bởi các khách hàng khác
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="create_customer_gender">Giới tính <span class="text-danger">*</span></label>
                                    <select class="form-control" id="create_customer_gender" name="create_customer_gender">
                                        <option value="M">Nam</option>
                                        <option value="F">Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="create_customer_birthday">Ngày sinh</label>
                                <div class="input-group">
                                    <input type="text" data-mask="99/99/9999" class="form-control" id="create_customer_birthday" name="create_customer_birthday" placeholder="dd/mm/yyyy">
                                    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                </div>
                            </div>
                        </div>
                        <h6>Thông tin thêm</h6>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="create_customer_check_add_address" name="create_customer_check_add_address">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Thêm địa chỉ</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row add-address">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="province" class="col-md-12">Tỉnh/Thành phố</label>
                                    <select data-placeholder="Chọn Tỉnh/Thành phố"  name="create_customer_province" id="create_customer_province" title="Chọn Tỉnh/Thành phố"></select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="district" class="col-md-12">Quận/Huyện</label>
                                    <select data-placeholder="Chọn Quận/Huyện" title="Chọn Quận/Huyện" name="create_customer_district" id="create_customer_district"></select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="ward" class="col-md-12">Phường/Xã</label>
                                    <select data-placeholder="Chọn Phường/Xã" title="Chọn Phường/Xã" name="create_customer_ward" id="create_customer_ward"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row add-address">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="house_street">Số nhà, tên đường</label>
                                    <textarea class="form-control" id="create_customer_house_street" name="create_customer_house_street" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted m-b-30 font-13">Mật khẩu mặc định cho tài khoản này là <b>"password"</b></p>
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="create_customer_check_change_pass" name="create_customer_check_change_pass">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Đổi mật khẩu</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row add-pass">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="create_role_name">Mật khẩu</label>
                                    <input class="form-control" type="password" name="create_customer_password" id="create_user_password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="create_role_name">Nhập lại mật khẩu</label>
                                    <input class="form-control" type="password" name="create_customer_confirm_password" id="create_user_confirm_password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="create_customer_check_add_avatar" name="create_customer_check_add_avatar">
                                        <span class="custom-control-indicator"></span>
                                        <span class="custom-control-description">Thêm ảnh đại diện</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row add-avatar">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="create_role_name">Ảnh đại diện</label>
                                    <input type="file" id="create_customer_avatar" name="create_customer_avatar" class="dropify" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="ti-plus"></i> {{ __('Hoàn thành') }}</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- modal view customer -->
    <div id="modal_view_customer" class="modal animated bounceInDown" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Thông tin khách hàng</h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="ti-close"></i> {{ __('Đóng') }}</button>
                </div>
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
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dropify/dist/js/dropify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/bootstrap-inputmask/bootstrap-inputmask.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/customers.js') }}"></script>
@endsection
