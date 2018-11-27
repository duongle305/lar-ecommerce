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
@endsection

@section('pageJS')
    <script type="text/javascript" src="{{ asset('assets/vendors/nestable/jquery.nestable.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/menu-items.js') }}"></script>
@endsection