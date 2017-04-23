<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ isset($page_title)?$page_title:"City Cars Satna :: App" }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('styles')
</head>
<body>
@include('partials.notify')
@yield('content')
</body>
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/dist/js/app.min.js"></script>
<script src="/js/notify.min.js"></script>
@include('partials.notify')
<script>$.fn.datepicker.defaults.format = "dd/mm/yyyy";</script>
@yield('scripts')
</html>