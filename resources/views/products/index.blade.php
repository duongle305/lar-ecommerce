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
<link rel="stylesheet" href="{{asset('assets/vendors/fine-uploader/fine-uploader-new.css')}}">
<style>
    #trigger-upload {
        color: white;
        background-color: #00ABC7;
        font-size: 14px;
        padding: 7px 20px;
        background-image: none;
    }

    #fine-uploader-manual-trigger .qq-upload-button {
        margin-right: 15px;
    }

    #fine-uploader-manual-trigger .buttons {
        width: 36%;
    }

    #fine-uploader-manual-trigger .qq-uploader .qq-total-progress-bar-container {
        width: 60%;
    }
</style>
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
                            <form id="form_create_product" action="{{ route('products.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="create_product_code">Mã sản phẩm</label>
                                            <label class="custom-control custom-checkbox ml-20">
                                                <input type="checkbox" class="custom-control-input" id="create_product_check_auto_code" name="create_product_check_auto_code">
                                                <span class="custom-control-indicator"></span>
                                                <span class="custom-control-description">Tự động tạo mã</span>
                                            </label>
                                            <div class="form-group add-code">
                                                <input type="text" class="form-control" id="create_product_code" name="create_product_code" placeholder="Mã sản phẩm">
                                                <p class="text-muted m-b-30 font-13 mt-20">Mã phải là một chuỗi kí tự có độ dài tối thiểu 10, bao gồm chữ in hoa và số</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="create_product_name">Tên sản phẩm</label>
                                            <input type="text" class="form-control" id="create_product_name" name="create_product_name" placeholder="Tên sản phẩm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="create_product_brand">Thương hiệu</label>
                                            <select class="form-control" id="create_product_brand" name="create_product_brand" data-placeholder="Thương hiệu"></select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="create_product_category">Loại sản phẩm</label>
                                            <select class="form-control" id="create_product_category" name="create_product_category" data-placeholder="Loại sản phẩm"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="create_product_price">Giá (VNĐ)</label>
                                            <input type="text" value="0" class="form-control" id="create_product_price" name="create_product_price" placeholder="Giá sản phẩm" data-a-sep="." data-a-dec=",">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="create_product_discount">Khuyến mãi (%)</label>
                                            <input type="number" min="0" class="form-control" id="create_product_discount" name="create_product_discount" placeholder="Khuyến mãi" value="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <label for="create_product_quantity">Số lượng</label>
                                            <input type="number" min="0" value="0" class="form-control" id="create_product_quantity" name="create_product_quantity" placeholder="Số lượng" >
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12 mb-20"><h5>Thông số kĩ thuật</h5></div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <input type="text" id="create_product_attribute_name" class="form-control"  placeholder="Tên">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <input type="text" id="create_product_attribute_value" class="form-control"  placeholder="Thông tin">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <button type="button" id="add_attribute_btn" class="btn btn-success" ><i class="ti-plus"></i> {{ __('Thêm') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <table class="table mb-md-0">
                                                <thead>
                                                <tr>
                                                    <th>Tên</th>
                                                    <th>Thông tin</th>
                                                    <th class="text-center">!!!</th>
                                                </tr>
                                                </thead>
                                                <tbody id="table_attribute_body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="create_product_note">Ghi chú sản phẩm</label>
                                            <textarea id="create_product_note" name="create_product_note" class="note-editable panel-body" contenteditable="true"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="create_product_description">Mô tả sản phẩm</label>
                                            <textarea id="create_product_description" name="create_product_description" class="note-editable panel-body" contenteditable="true" data-url="{{ route('products.upload-image') }}"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="edit_brand_logo">Ảnh Thumbnail</label>
                                            <input type="file" id="create_product_thumbnail" name="create_product_thumbnail" class="dropify" accept="image/*">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="edit_brand_logo">Hình sản phẩm</label>
                                            <div id="my-uploader"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group modal-footer">
                                            <button type="button" class="btn btn-info reload"><i class="ti-reload reload"></i> {{ __('Reset') }}</button>
                                            <button type="submit" class="btn btn-primary"><i class="ti-check"></i> {{ __('Hoàn thành') }}</button>
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
<script type="text/javascript" src="{{ asset('assets/vendors/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/autoNumeric/autoNumeric-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/fine-uploader/jquery.fine-uploader.js') }}"></script>
<script type="text/template" id="qq-template">
    <div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
        <div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
            <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
        </div>
        <div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
            <span class="qq-upload-drop-area-text-selector"></span>
        </div>
        <div class="qq-upload-button-selector qq-upload-button">
            <div>Thêm ảnh</div>
        </div>
        <span class="qq-drop-processing-selector qq-drop-processing">
                    <span>Processing dropped files...</span>
                    <span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
                </span>
        <ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
            <li>
                <div class="qq-progress-bar-container-selector">
                    <div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
                </div>
                <span class="qq-upload-spinner-selector qq-upload-spinner"></span>
                <img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
                <span class="qq-upload-file-selector qq-upload-file"></span>
                <span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
                <input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
                <span class="qq-upload-size-selector qq-upload-size"></span>
                <button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Hủy</button>
                <button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Thử lại</button>
                <button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Xóa</button>
                <span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
            </li>
        </ul>

        <dialog class="qq-alert-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Đóng</button>
            </div>
        </dialog>

        <dialog class="qq-confirm-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Không</button>
                <button type="button" class="qq-ok-button-selector">Có</button>
            </div>
        </dialog>

        <dialog class="qq-prompt-dialog-selector">
            <div class="qq-dialog-message-selector"></div>
            <input type="text">
            <div class="qq-dialog-buttons">
                <button type="button" class="qq-cancel-button-selector">Hủy</button>
                <button type="button" class="qq-ok-button-selector">Ok</button>
            </div>
        </dialog>
    </div>
</script>

<script type="text/javascript" src="{{ asset('assets/js/products.js') }}"></script>
@endsection
