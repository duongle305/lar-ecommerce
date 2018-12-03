@extends('layouts.app')
@section('dashboard_active','active')
@section('pageCSS')
    <link rel="stylesheet" href="{{ asset('assets/vendors/nestable/nestable.css') }}">
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
                                <h5 class="mb-2">Menu builder</h5>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <form id="form_create_menu_item" action="{{ route('menu-builders.menu-items.store') }}">
                                            <input type="hidden" name="menu_id" value="{{ request()->route('id') }}">
                                            <div class="form-group">
                                                <label>Title of the Menu item <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="title" placeholder="Title">
                                            </div>
                                            <div class="form-group">
                                                <label>Font icon class for the Menu item (Themify Icons)</label>
                                                <input type="text" class="form-control" name="icon_class" placeholder="Font icon class">
                                            </div>
                                            <div class="form-group">
                                                <label for="link_type">Link type</label>
                                                <select id="link_type" name="link_type" class="form-control">
                                                    <option value="url">Static URL</option>
                                                    <option value="route">Dynamic route</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="url">URL for Menu item <span class="text-danger">*</span></label>
                                                <input type="text" name="url" id="url" class="form-control" placeholder="URL">
                                            </div>
                                            <div class="form-group" style="display: none;">
                                                <label for="route">Route for menu item <span class="text-danger">*</span></label>
                                                <input type="text" name="route" id="route" class="form-control" placeholder="Route">
                                            </div>
                                            <div class="form-group" style="display: none;">
                                                <label for="parameters">Route parameters</label>
                                                <textarea name="parameters" id="parameters" class="form-control" rows="3" placeholder='{"key":"value"}'></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="target">Open In <span class="text-danger">*</span></label>
                                                <select id="target" name="target" class="form-control">
                                                    <option value="_self">Same tab/Window</option>
                                                    <option value="_blank">New tab/Window</option>
                                                </select>
                                            </div>
                                            <div class="form-group text-xs-right">
                                                 <button type="button" id="btn-reset-create-menu" class="btn btn-secondary">Reset</button>
                                                <button class="btn btn-success">Thêm</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="hidden" id="menu_id" value="{{ request()->route('id') }}">
                                        <div class="dd" id="menu-items"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal_edit_menu_item" class="modal animated bounceInDown" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form_edit_menu_item" action="{{ route('menu-builders.menu-items.update') }}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h5 class="modal-title text-uppercase"><i class="ti-menu"></i> Sửa</h5>
                    </div>
                    <div class="modal-body">
                            <input type="hidden" name="edit_menu_item_id" id="edit_menu_item_id">
                            <div class="form-group">
                                <label>Title of the Menu item <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_title" name="edit_title" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label>Font icon class for the Menu item (Themify Icons)</label>
                                <input type="text" class="form-control" id="edit_icon_class" name="edit_icon_class" placeholder="Font icon class">
                            </div>
                            <div class="form-group">
                                <label for="edit_link_type">Link type</label>
                                <select id="edit_link_type" name="edit_link_type" class="form-control">
                                    <option value="url">Static URL</option>
                                    <option value="route">Dynamic route</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_url">URL for Menu item <span class="text-danger">*</span></label>
                                <input type="text" name="edit_url" id="edit_url" class="form-control" placeholder="URL">
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="edit_route">Route for menu item <span class="text-danger">*</span></label>
                                <input type="text" name="edit_route" id="edit_route" class="form-control" placeholder="Route">
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="edit_parameters">Route parameters</label>
                                <textarea name="edit_parameters" id="edit_parameters" class="form-control" rows="3" placeholder='{"key":"value"}'></textarea>
                            </div>
                            <div class="form-group">
                                <label for="edit_target">Open In <span class="text-danger">*</span></label>
                                <select id="edit_target" name="edit_target" class="form-control">
                                    <option value="_self">Same tab/Window</option>
                                    <option value="_blank">New tab/Window</option>
                                </select>
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
    <script type="text/javascript" src="{{ asset('assets/js/menu-items.js') }}"></script>
@endsection