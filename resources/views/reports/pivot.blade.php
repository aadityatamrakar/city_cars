<!DOCTYPE html>
<html>
<head>
    <title>Pivot Demo From Local CSV</title>
    <script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-46914903-1', 'kruchten.com');  ga('send', 'pageview');</script>
    <!-- external libs from cdnjs -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.css">

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/PapaParse/4.1.2/papaparse.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.11/c3.min.js"></script>

    <!-- PivotTable.js libs from ../dist -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.11.1/pivot.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.11.1/pivot.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.11.1/c3_renderers.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.11.1/d3_renderers.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pivottable/2.11.1/export_renderers.min.js"></script>
    <style>
        .c3-line, .c3-focused {stroke-width: 3px !important;}
        .c3-bar {stroke: white !important; stroke-width: 1;}
        .c3 text { font-size: 12px; color: grey;}
        .tick line {stroke: white;}
        .c3-axis path {stroke: grey;}
        .c3-circle { opacity: 1 !important; }
        .c3-xgrid-focus {visibility: hidden !important;}
    </style>
</head>
<body class="whiteborder">
<script type="text/javascript">
    $(function(){
        var renderers = $.extend(
            $.pivotUtilities.renderers,
            $.pivotUtilities.c3_renderers,
            $.pivotUtilities.d3_renderers,
            $.pivotUtilities.export_renderers
        );

        Papa.parse("{{ route('reports.csv', ["id"=>$id]) }}", {
            download: true,
            header: true,
            skipEmptyLines: true,
            complete: function(parsed){
                $("#output").pivotUI(parsed.data, {
                hiddenAttributes: [""],
                renderers: renderers }, true);
            }
        });

    });
</script>
<div id="output" style="margin: 10px;">Loading...</div>
</body>
</html>
