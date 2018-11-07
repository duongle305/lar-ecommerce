@extends('auth.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="sign-form">
            <div class="row">
                <div class="col-md-4 offset-md-4 px-3">
                    <div class="card">
                        <div class="card-block">
                            <div class="p-2 text-xs-center">
                                <h5 class="text-uppercase">Đăng nhập</h5>
                            </div>
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group {{ $errors->has('email') ? 'has-danger' : '' }}">
                                    <label>E-mail</label>
                                    <input type="text" name="email" class="form-control" placeholder="E-mail">
                                    @if ($errors->has('email'))
                                        <span class="form-control-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password') ? 'has-danger' : '' }}">
                                    <label>Mật khẩu</label>
                                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                                    @if ($errors->has('password'))
                                        <span class="form-control-feedback">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="form-group text-xs-right">
                                    <button class="btn btn-primary text-uppercase">Đăng Nhập</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection