@extends('layouts.app')
@section('dashboard_active','active')
@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.bootstrap4.min.css') }}">
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
                            <a class="nav-link active" data-toggle="tab" href="#tab1">Danh mục thương hiệu</a>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <div class="tab-content">
                        <div id="tab1" class="tab-pane active">
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <h5 class="mb-2">Danh mục thương hiệu</h5>
                                </div>
                                <div class="col-lg-6 text-xs-right">
                                    <button class="btn btn-success" data-toggle="modal"
                                            data-target="#modal_create_brand">Thêm mới
                                    </button>
                                    <button class="btn btn-primary" id="btn-reload-brands"
                                            data-href="{{ route('brands.all-brands') }}">Tải lại
                                    </button>
                                </div>
                            </div>
                            <table id="table_brands" class="table table-striped table-bordered" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tên</th>
                                    <th>Tên hiển thị</th>
                                    <th>Logo</th>
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
<!-- Modal edit brand -->
<div id="modal_edit_brand" class="modal animated bounceInDown" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_edit_brand" action="{{ route('brands.update') }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Cập nhật thương hiệu</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="edit_brand_id" id="edit_brand_id">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="edit_brand_slug">Tên <span class="text-danger">*</span></label>
                                <input class="form-control bg-faded" id="edit_brand_slug" name="edit_brand_slug" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="edit_brand_name">Tên hiển thị <span class="text-danger">*</span></label>
                                <input class="form-control" name="edit_brand_name" id="edit_brand_name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_brand_note">Ghi chú</label>
                        <textarea class="form-control" name="edit_brand_note" id="edit_brand_note" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_brand_logo">Logo</label>
                        <input type="file" id="edit_brand_logo" name="edit_brand_logo" class="dropify" data-default-file="{{ asset('storage/uploads/brand_logo/default_logo.png') }}" accept="image/*">
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
<!-- Modal create brand -->
<div id="modal_create_brand" class="modal animated bounceInDown" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_create_brand" action="{{ route('brands.store') }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Tạo mới thương hiệu</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="create_brand_slug">Tên <span class="text-danger">*</span></label>
                                <input class="form-control bg-faded" id="create_brand_slug" name="create_brand_slug" readonly>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="create_brand_name">Tên hiển thị <span class="text-danger">*</span></label>
                                <input class="form-control" name="create_brand_name" id="create_brand_name">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="create_brand_note">Ghi chú</label>
                        <textarea class="form-control" name="create_brand_note" id="create_brand_note" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="create_brand_logo">Logo</label>
                        <input type="file" id="create_brand_logo" name="create_brand_logo" class="dropify" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="ti-check"></i> {{ __('Hoàn thành') }}</button>
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
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dropify/dist/js/dropify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/brands.js') }}"></script>
@endsection
