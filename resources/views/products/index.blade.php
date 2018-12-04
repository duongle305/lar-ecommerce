@extends('layouts.app')
{{--@section('dashboard_active','active')--}}
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
                            <a class="nav-link active" data-toggle="tab" href="#tab1">Danh mục sản phẩm</a>
                        </li>
                    </ul>
                </div>
                <div class="card-block">
                    <div class="tab-content">
                        <div id="tab1" class="tab-pane active">
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <h5 class="mb-2">Danh mục Sản phẩm</h5>
                                </div>
                                <div class="col-lg-6 text-xs-right">
                                    <a class="btn btn-success" href="{{ route('products.create') }}">Thêm mới
                                    </a>
                                    <button class="btn btn-primary" id="btn-reload-products"
                                            data-href="{{ route('products.all') }}">Tải lại
                                    </button>
                                </div>
                            </div>
                            <table id="table_products" class="table table-striped table-bordered" style="width: 100%;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Tên</th>
                                    <th>Trạng thái</th>
                                    <th>Thương hiệu</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Ảnh</th>
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
<div id="modal_create_product" class="modal animated bounceInDown" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form_create_customer" action="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Thêm mới sản phẩm</h5>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="ti-plus"></i> {{ __('Hoàn thành') }}</button>
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
<script type="text/javascript" src="{{ asset('assets/vendors/dropify/dist/js/dropify.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/products.js') }}"></script>
@endsection
