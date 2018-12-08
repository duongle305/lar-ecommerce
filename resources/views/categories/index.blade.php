@extends('layouts.app')
@section('dashboard_active','active')
@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('assets/vendors/nestable/nestable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/dropify/dist/css/dropify.min.css') }}">

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
                                <a class="nav-link active" data-toggle="tab" href="#tab1">Menu</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane active">
                                <h5 class="mb-2">Quản lý danh mục</h5>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <form id="form_create_category" action="{{ route('categories.store') }}">
                                            <div class="form-group">
                                                <label for="title">Tên danh mục <span class="text-danger">*</span></label>
                                                <input type="text" name="title" id="title" class="form-control" placeholder="Tên danh mục">
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label for="create_category_icons">Icon danh mục</label>
                                                        <input type="file" id="create_category_icons" name="create_category_icons" class="dropify" accept="image/*">
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="create_category_icons">Icon khi di chuột vào</label>
                                                        <input type="file" id="create_category_icons_hover" name="create_category_icons_hover" class="dropify" accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="note">Ghi chú</label>
                                                <textarea class="form-control" name="note" id="note" rows="3" placeholder="Ghi chú"></textarea>
                                            </div>
                                            <div class="form-group text-xs-right">
                                                <button type="button" class="btn btn-secondary"><i class=""></i> Reset</button>
                                                <button type="submit" class="btn btn-success"><i class="ti-plus"></i> Thêm</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="dd" id="categories"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_edit_category" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_edit_category" action="{{ route('categories.update') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Sửa</h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_category_id" id="edit_category_id">
                        <div class="form-group">
                            <label for="title">Tên danh mục <span class="text-danger">*</span></label>
                            <input type="text" name="edit_title" id="edit_title" class="form-control" placeholder="Tên danh mục">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="note">Icon hiển thị</label>
                                    <input type="file" id="edit_category_icon" name="edit_category_icon" class="dropify" accept="image/*">
                                </div>
                                <div class="col-lg-6">
                                    <label for="note">Icon hiển thị khi di chuột</label>
                                    <input type="file" id="edit_category_icon_hover" name="edit_category_icon_hover" class="dropify" accept="image/*">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="note">Ghi chú</label>
                            <textarea class="form-control" name="edit_note" id="edit_note" rows="3" placeholder="Ghi chú"></textarea>
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
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('assets/vendors/nestable/jquery.nestable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/dropify/dist/js/dropify.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/categories.js') }}"></script>
@endsection
