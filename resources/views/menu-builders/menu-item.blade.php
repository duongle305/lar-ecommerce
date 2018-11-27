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
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form action="{{ route('menu-builders.menu-items.store') }}">
                                            <div class="form-group">

                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="hidden" id="menu_id" value="{{ request()->route('id') }}">
                                        <div class="dd" id="menu-items">
                                        </div>
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