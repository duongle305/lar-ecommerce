@extends('layouts.app')
@section('dashboard_active','active')
@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/css/dropify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/dist/css/select2.min.css') }}">

@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs float-xs-left">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab1">Danh mục slider quảng cáo</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <h5 class="mb-2">Danh mục slider quảng cáo</h5>
                                    </div>
                                    <div class="col-lg-6 text-xs-right">
                                        <button class="btn btn-success" data-toggle="modal"
                                                data-target="#modal_create_slider">Thêm mới
                                        </button>
                                        <button class="btn btn-primary" id="btn-reload-sliders"
                                                data-href="{{ route('sliders.all') }}">Tải lại
                                        </button>
                                    </div>
                                </div>
                                <table id="table_sliders" class="table table-striped table-bordered" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Trạng thái</th>
                                        <th>Url</th>
                                        <th>Ảnh</th>
                                        <th>Ghi chú</th>
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
    <!-- Modal edit slider -->
    <div id="modal_edit_slider" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_edit_slider" action="{{ route('sliders.update') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Cập nhật slider</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_slider_id" id="edit_slider_id">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="edit_slider_url">Liên kết <span class="text-danger">*</span></label>
                                    <input class="form-control" name="edit_slider_url" id="edit_slider_url">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_slider_note">Ghi chú</label>
                            <textarea class="form-control" name="edit_slider_note" id="edit_slider_note" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_slider_image">Ảnh slide</label>
                            <input type="file" id="edit_slider_image" name="edit_slider_image" class="dropify" accept="image/*">
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
    <!-- Modal create slider -->
    <div id="modal_create_slider" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_create_slider" action="{{ route('sliders.store') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Tạo mới slider</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="create_slider_url">Nhập liên kết <span class="text-danger">*</span></label>
                                    <input class="form-control" name="create_slider_url" id="create_slider_url">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="create_slider_note">Ghi chú</label>
                            <textarea class="form-control" name="create_slider_note" id="create_slider_note" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="create_slider_image">Ảnh slide <span class="text-danger">*</span></label>
                            <input type="file" id="create_slider_image" name="create_slider_image" class="dropify" accept="image/*">
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
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.print.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/DataTables/Buttons/js/buttons.colVis.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dropify/dist/js/dropify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/select2/dist/js/select2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/sliders.js') }}"></script>
@endsection
