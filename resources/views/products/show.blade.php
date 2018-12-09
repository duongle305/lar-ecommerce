@extends('layouts.app')
{{--@section('dashboard_active','active')--}}
@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/DataTables/Buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl.carousel/assets/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl.carousel/assets/owl.theme.default.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs float-xs-left">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tab1">Chi tiết sản phẩm</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <div class="row mb-2">
                                    <div class="col-lg-12">
                                        <h4 class="mb-2">{{ $product->title }}</h4>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-8">
                                        <table class="table mb-md-0">
                                            <tbody>
                                            <tr>
                                                <th scope="row">Mã</th>
                                                <td>{{ $product->code }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Giá</th>
                                                <td>{{ number_format($product->price,0) }} VNĐ</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Số lượng</th>
                                                <td>{{ $product->quantity }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Khuyến mãi</th>
                                                <td>{{ $product->discount }}%</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Thương hiệu</th>
                                                <td>{{ $product->brand->name }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Loại sản phẩm</th>
                                                <td>
                                                    @foreach($product->categories as $index => $category)
                                                        @if($index == ($product->categories->count() -1))
                                                            {!! "<b>{$category->title}</b>" !!}
                                                        @else
                                                            {!! "<b>{$category->title}</b>".',' !!}
                                                        @endif
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Trạng thái</th>
                                                <td>{!! ($product->state == 'ACTIVE') ? '<div class="text-success">Hiển thị</div>' : '<div class="text-danger">Không hiển thị</div>' !!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Ghi chú</th>
                                                <td>{!! $product->note !!}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Thời gian tạo</th>
                                                <td>{{ date_format($product->created_at,'d/m/Y, H:i') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Lần cập nhật gần nhất</th>
                                                <td>{{ date_format($product->updated_at,'d/m/Y, H:i') }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="owl-carousel owl-theme full-width">
                                            @foreach($product->images as $index => $image)
                                            <div class="carousel-item">
                                                <img src="{{ asset($image->path) }}" alt="image"/>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2 text-center justify-content-center">
                                    <div class="col-lg-6">
                                        <h4 class="mb-2">Thông số kỹ thuật</h4>
                                        <table class="table mb-md-0">
                                            <tbody>
                                            @foreach($product->attributes as $attribute)
                                            <tr>
                                                <td>{{ $attribute->title }}</td>
                                                <td>{{ $attribute->value }}</td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row mb-2 text-center justify-content-center">
                                    <div class="col-lg-12">
                                        <h4 class="mb-2">Mô tả sản phẩm</h4>
                                        {!! $product->description !!}
                                    </div>
                                </div>
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
    <script type="text/javascript" src="{{ asset('assets/vendors/owl.carousel/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            if($('.owl-carousel').length) {
                $('.full-width').owlCarousel({
                    loop: true,
                    margin: 0,
                    items: 1,
                    nav: false,
                    autoplay: true,
                    autoplayTimeout:5500,
                });
            }
        })
    </script>
@endsection
