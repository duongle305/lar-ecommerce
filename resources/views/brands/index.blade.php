@extends('layouts.app')
@section('dashboard_active','active')
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
                            <a class="nav-link active" data-toggle="tab" href="#tab1">Danh mục thương hiệu</a>
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
                                    <h5 class="mb-2">Danh mục thương hiệu</h5>
                                </div>
                                <div class="col-lg-6 text-xs-right">
                                    <button class="btn btn-success" data-toggle="modal"
                                            data-target="#modal_create_permission">Thêm mới
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
    <script type="text/javascript" src="{{ asset('assets/js/brands.js') }}"></script>
@endsection
