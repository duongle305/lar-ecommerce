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
                                <a class="nav-link active" data-toggle="tab" href="#tab2">Cập nhật sản phẩm</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div id="tab2" class="tab-pane active">
                                <div class="row mb-2">
                                    <div class="col-lg-6">
                                        <h5 class="mb-2">Cập nhật Sản phẩm</h5>
                                    </div>
                                </div>
                                <form id="form_edit_product" action="{{ route('products.update') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $product->id }}">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="product_code">Mã sản phẩm</label>
                                                <div class="form-group">
                                                    <input type="text" class="form-control"  placeholder="Mã sản phẩm" readonly value="{{ $product->code }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="product_name">Tên sản phẩm</label>
                                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Tên sản phẩm" value="{{ $product->title }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="brand">Thương hiệu</label>
                                                <select class="form-control" id="brand" name="brand" data-placeholder="Thương hiệu" >
                                                    <option value="{{ $product->brand->id }}" selected>{{ $product->brand->name }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="categories">Loại sản phẩm</label>
                                                <select class="form-control" id="categories" name="categories" data-placeholder="Loại sản phẩm" multiple="multiple">
                                                    @foreach($product->categories as $category)
                                                        <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="price">Giá (VNĐ)</label>
                                                <input type="text" value="{{ $product->price }}" class="form-control" id="price" name="price" placeholder="Giá sản phẩm" data-a-sep="." data-a-dec=",">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="discount">Khuyến mãi (%)</label>
                                                <input type="number" min="0" class="form-control" id="discount" name="discount" placeholder="Khuyến mãi" value="{{ $product->discount }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="quantity">Số lượng</label>
                                                <input type="number" min="0" value="{{ $product->quantity }}" class="form-control" id="quantity" name="quantity" placeholder="Số lượng" >
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-12 mb-20"><h5>Thông số kĩ thuật</h5></div>
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <input type="text" id="attribute_name" class="form-control"  placeholder="Tên">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <input type="text" id="attribute_value" class="form-control"  placeholder="Thông tin">
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
                                        <div class="col-lg-7">
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
                                                    @foreach($product->attributes as $attribute)
                                                        <tr>
                                                            <td>{{ $attribute->title }}</td>
                                                            <td>{{ $attribute->value }}</td>
                                                            <td class="text-center">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-warning edit-attribute">Sửa</button>
                                                                    <button type="button" class="btn btn-danger delete-attribute">Xóa</button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="note">Ghi chú sản phẩm</label>
                                                <textarea id="note" name="note" class="note-editable panel-body" contenteditable="true">{{ $product->note }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description">Mô tả sản phẩm</label>
                                                <textarea id="description" name="description" class="note-editable panel-body" contenteditable="true" data-url="{{ route('products.upload-image') }}">{{ $product->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="thumbnail">Ảnh Thumbnail</label>
                                                <input type="file" id="thumbnail" name="thumbnail" class="dropify" accept="image/*" data-default-file="{{ asset($product->thumbnail) }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="product_images">Thêm hình sản phẩm</label>
                                                <div id="product_images"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label for="thumbnail">Hình đang có</label>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row" id="product_images_show">
                                                @foreach($product->images as $image)
                                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="card">
                                                            <img class="card-img-top img-fluid hoverZoomLink" src="{{ asset($image->path) }}" alt="Card image cap">
                                                            <div class="card-block text-center">
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal_edit_image" data-url="{{ route('product.get-image',$image->id) }}" data-id="{{ $image->id }}">Sửa</button>
                                                                    <button type="button" class="btn btn-danger image-delete" data-url="{{ route('products.edit.delete-image',$image->id) }}">Xóa</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group modal-footer">
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
    <!-- Modal edit product image -->
    <div id="modal_edit_image" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_edit_product_iamge" action="{{ route('products.edit-image') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Cập nhật ảnh sản phẩm</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="image_id" name="image_id">
                        <div class="form-group">
                            <input type="file" id="edit_product_image" name="edit_product_image" class="dropify" accept="image/*">
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

    <script type="text/javascript" src="{{ asset('assets/js/products_edit.js') }}"></script>
@endsection
