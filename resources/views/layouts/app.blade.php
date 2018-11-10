<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap4/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/jscrollpane/jquery.jscrollpane.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/waves/waves.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/switchery/dist/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/toastr/toastr.min.css') }}">


    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <!-- Page CSS -->
    @yield('pageCSS')
</head>
<body class="fixed-sidebar fixed-header skin-6 material-design">
<div class="wrapper">

    <!-- Preloader -->
    <div class="preloader"></div>

    @include('layouts.sidebar')

    @include('layouts.header')

    <div class="site-content">
        <!-- Content -->
        <div class="content-area py-1">
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>

</div>

<!-- Vendor JS -->
<script type="text/javascript" src="{{ asset('assets/vendors/jquery/jquery-1.12.3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/tether/js/tether.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/bootstrap4/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/detectmobilebrowser/detectmobilebrowser.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/jscrollpane/jquery.mousewheel.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/jscrollpane/mwheelIntent.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/jscrollpane/jquery.jscrollpane.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/jquery-fullscreen-plugin/jquery.fullscreen-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/waves/waves.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/switchery/dist/switchery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/vue/vue.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/axios/axios.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/toastr/toastr.min.js') }}"></script>



<!-- Core JS -->
<script type="text/javascript" src="{{ asset('assets/js/app.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/demo.js') }}"></script>
<!-- Page JS -->
@yield('pageJS')
</body>
</html>
