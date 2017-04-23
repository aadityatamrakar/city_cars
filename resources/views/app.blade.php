<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@section('pagetitle')City Cars App :: @show</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="/dist/css/skins/skin-blue.css">
    <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="/plugins/select2/select2.min.css">
    {{--<link rel="stylesheet" href="/plugins/datatables/jquery.dataTables.min.css">--}}
    <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" href="/plugins/pace/pace.min.css" />
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Style for Views -->
    @yield('styles')
</head>
<body class="hold-transition skin-blue sidebar-mini" style="overflow: hidden;">
<div class="wrapper" style="overflow: hidden;">
    @include('partials.header')
    @include('partials.side_nav')
    <div class="content-wrapper">
        @yield('content')
    </div>
    @include('partials.footer')
</div>
</body>
<!-- ALL REQURED JAVASCRIPTS -->
<script src="/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<script src="/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="/plugins/select2/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/js/notify.min.js"></script>
<script src="/plugins/pace/pace.min.js"></script>
@include('partials.notify')
<script src="/plugins/fastclick/fastclick.js"></script>
<script src="/dist/js/app.min.js"></script>
<script src="/js/translator.js"></script>
<script>
    $(document).ready(function (){
        String.prototype.replaceAll = function(search, replacement) {
            var target = this;
            return target.replace(new RegExp(search, 'g'), replacement);
        };
        $.fn.datepicker.defaults.format = "dd/mm/yyyy";
        $(document).ajaxStart(function() { Pace.restart(); });
        $(".content-wrapper").css('height', $(".content-wrapper").css('min-height'));
        $(".content-wrapper").css('overflow-y', 'scroll');
    });
</script>
<!-- JAVASCRIPTS LOADED BY VIEWS -->
@yield('scripts')
</html>