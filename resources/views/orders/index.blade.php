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
                                <a class="nav-link active" data-url="{{ route('orders.all-orders',1) }}" data-toggle="tab" href="#" id="tab1">Chờ xử lý</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-url="{{ route('orders.all-orders',2) }}" data-toggle="tab" href="#">Sẵn sàng giao</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-url="{{ route('orders.all-orders',3) }}" data-toggle="tab" href="#">Đang giao</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-url="{{ route('orders.all-orders',4) }}" data-toggle="tab" href="#">Hoàn thành</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-url="{{ route('orders.all-orders',5) }}" data-toggle="tab" href="#">Hủy bỏ</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-url="{{ route('orders.all-orders',6) }}" data-toggle="tab" href="#">Thất bại</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-url="{{ route('orders.all-orders',7) }}" data-toggle="tab" href="#">Trả hàng</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div id="tab" class="tab-pane active">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <h5 class="mb-2" id="tab-title">Danh Mục Đơn Hàng Chờ Xử Lý</h5>
                                    </div>
                                </div>
                                <table id="table_orders" class="table table-striped table-bordered" style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Mã</th>
                                        <th>Ngày đặt hàng</th>
                                        <th>Người đặt hàng</th>
                                        <th>Số lượng sp</th>
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
    <!-- Modal view order -->
    <div id="modal_order_detail" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form_transfer_brand" action="{{ route('brands.transfer-submit') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Chi tiết đơn đặt hàng: <span id="order_code"></span></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <h5 class="text-left">Thông tin khách hàng</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody class="text-left">
                                            <tr>
                                                <th>Họ & tên</th>
                                                <td id="customer_name"></td>
                                            </tr>
                                            <tr>
                                                <th>Số điện thoại</th>
                                                <td id="customer_phone"></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td id="customer_email"></td>
                                            </tr>
                                            <tr>
                                                <th>Địa chỉ</th>
                                                <td id="customer_address"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h5 class="text-left">Thông tin đơn hàng</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody class="text-left">
                                            <tr>
                                                <th>Trạng thái</th>
                                                <td id="order_status"></td>
                                            </tr>
                                            <tr>
                                                <th>Ngày đặt</th>
                                                <td id="order_date"></td>
                                            </tr>
                                            <tr>
                                                <th>Số SP</th>
                                                <td id="total_product"></td>
                                            </tr>
                                            <tr>
                                                <th>Tổng giá</th>
                                                <td id="total_price"></td>
                                            </tr>
                                            <tr>
                                                <th>Địa chỉ giao</th>
                                                <td id="order_address"></td>
                                            </tr>
                                            <tr>
                                                <th>Ghi chú</th>
                                                <td id="order_note"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="text-left">Sản phẩm</h4><br>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Mã SP</th>
                                            <th>Tên SP</th>
                                            <th>Đơn giá</th>
                                            <th>Số lượng</th>
                                        </tr>
                                        </thead>
                                        <tbody id="ordrt_products">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
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
    <script type="text/javascript" src="{{ asset('assets/js/orders.js') }}"></script>

@endsection
