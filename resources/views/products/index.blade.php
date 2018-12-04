@extends('layouts.app')
{{--@section('dashboard_active','active')--}}
@section('pageCSS')
<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/css/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/summernote/dist/summernote-bs4.css') }}">

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
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab2">Tạo mới sản phẩm</a>
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
                        <div id="tab2" class="tab-pane">
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <h5 class="mb-2">Thêm mới Sản phẩm</h5>
                                </div>
                            </div>
                            <form id="form_create_customer" action="">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="create_product_name">Tên sản phẩm</label>
                                            <input type="text" class="form-control" id="create_product_name" name="create_product_name" placeholder="Tên sản phẩm">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="create_product_slug">Tên slug</label>
                                            <input type="text" class="form-control" id="create_product_slug" name="create_product_slug" placeholder="Tên slug" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="create_product_brand">Thương hiệu</label>
                                            <input type="number" min="0" class="form-control" id="create_product_brand" name="create_product_brand" placeholder="Thương hiệu">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="create_product_category">Loại sản phẩm</label>
                                            <input type="number" min="0" class="form-control" id="create_product_category" name="create_product_category" placeholder="Loại sản phẩm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="create_product_price">Giá</label>
                                            <input type="number" min="0" class="form-control" id="create_product_price" name="create_product_price" placeholder="Giá sản phẩm">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="create_product_discount">Khuyến mãi (%)</label>
                                            <input type="number" min="0" class="form-control" id="create_product_discount" name="create_product_discount" placeholder="Khuyến mãi">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="create_product_note">Ghi chú sản phẩm</label>
                                            <div id="create_product_note" class="note-editable panel-body" contenteditable="true"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="create_product_description">Mô tả sản phẩm</label>
                                            <div id="create_product_description" class="note-editable panel-body" contenteditable="true"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
<script type="text/javascript" src="{{ asset('assets/vendors/summernote/dist/summernote-bs4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/products.js') }}"></script>
@endsection
