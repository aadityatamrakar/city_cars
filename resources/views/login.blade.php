@extends('app_wo_nav')

@section('styles')
    <style>
        body{
            background: #E0EAFC; /* fallback for old browsers */
            background: -webkit-linear-gradient(to left, #E0EAFC , #CFDEF3); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to left, #E0EAFC , #CFDEF3); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        }
    </style>
@endsection

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('home') }}"><b>City</b>Cars</a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="{{ route('login') }}" method="post">
                {!! csrf_field() !!}
                <div class="form-group has-feedback">
                    <input type="email" class="form-control" name="email" placeholder="Email" value="{{ isset($_COOKIE['email'])?$_COOKIE['email']:'' }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
    </div>

@endsection