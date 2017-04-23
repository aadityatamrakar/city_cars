@extends('app')

@section('pagetitle', 'City Cars App - Reports')

@section('styles')
    <link rel="stylesheet" href="/css/query-builder.default.min.css" />
@endsection

@section('content')
    @include('partials.page_header', ['title'=>"Reports", 'desc'=>"Generate Reports"])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Report Creator <small>GUI</small></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form onsubmit="return false" method="post" class="form-horizontal">
                    <fieldset>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="title">Report Title</label>
                            <div class="col-md-6">
                                <input id="title" name="title" type="text" placeholder="" class="form-control input-md" required="">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="report_table">Report Table</label>
                            <div class="col-md-6">
                                <select id="report_table" name="report_table" class="form-control">
                                    <option value="">--select--</option>
                                    <option value="customers">Customer</option>
                                    <option value="vehicles">Vehicle+Customer</option>
                                    <option value="transactions">Transaction+Vehicle+Customer</option>
                                    <option value="sessions">Sessions</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="columns_header">Columns</label>
                            <div class="col-md-6">
                                <select id="columns_header" name="columns_header" class="form-control" multiple style="height: 32px; overflow: hidden;"></select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-sm btn-primary" onclick="$('#columns_header option').attr('selected', 'selected').trigger('change')">Select All</button>
                                <button class="btn btn-sm btn-danger" onclick="$('#columns_header option').removeAttr('selected').trigger('change')"><i class="fa fa-remove"></i> Clear</button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="where_query">Where</label>
                            <div class="col-md-8">
                                <div id="builder"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Actions</label>
                            <div class="col-md-6">
                                <button id="preview_report" class="btn btn-md btn-primary">Preview Report</button>
                                <button id="save_report" class="btn btn-md btn-success">Save Report</button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>
        <div class="box collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Report Creator <small>Raw SQL Query</small></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form onsubmit="return false" method="post" class="form-horizontal">
                    <fieldset>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="title">Report Title</label>
                            <div class="col-md-6">
                                <input id="title_raw" name="title_raw" type="text" placeholder="" class="form-control input-md" required="">

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="report_table_raw">Report Table</label>
                            <div class="col-md-6">
                                <select id="report_table_raw" name="report_table_raw" class="form-control">
                                    <option value="">--select--</option>
                                    <option value="customers">Customer</option>
                                    <option value="vehicles">Vehicle+Customer</option>
                                    <option value="transactions">Transaction+Vehicle+Customer</option>
                                    <option value="sessions">Sessions</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="select_query">SELECT Columns Names</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="select_query" name="select_query"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="headers_raw">Headers</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="headers_raw" name="headers_raw"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="where_query_raw">Where Query</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="where_query_raw" name="where_query_raw"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="params">Parameters</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="params" name="params"></input>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 control-label">Actions</label>
                            <div class="col-md-6">
                                <button id="preview_report_raw" class="btn btn-md btn-primary">Preview Report</button>
                                <button id="save_report_raw" class="btn btn-md btn-success">Save Report</button>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
        </div>

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Preview Data <small>First 10 records of Report</small></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped" id="preview_tbl">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal" tabindex="-1" id="errorModal" role="dialog" aria-labelledby="myLargeModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Error!</h4>
                </div>
                <div id="error_content" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="/js/doT.min.js"></script>
    <script src="/js/jQuery.extendext.min.js"></script>
    <script src="/js/query-builder.min.js"></script>
    <script>
        var sql_headers, sql_query, sql_select, rpt_tbl;
        var rules_basic = {
            condition: 'AND',
            rules: [{
                id: 'name',
                operator: 'contains',
                value: ''
            }]
        };

        $("#report_table_raw").on('change', function (){
            var v = $(this).val();
            var select_query = [];
            if(v == 'customers'){
                $.each(customer_filter, function (i, v){
                    select_query.push(v.field);
                })
            }else if(v == 'vehicles'){
                $.each(vehicle_filter, function (i, v){
                    select_query.push(v.field);
                })
            }else if(v == 'transactions'){
                $.each(transaction_filter, function (i, v){
                    select_query.push(v.field);
                })
            }else if(v == 'sessions'){
                $.each(session_filter, function (i, v){
                    select_query.push(v.field);
                })
            }

            $("#select_query").html(select_query.join(', '));
        });

        $("#preview_report_raw").click(function (){
            var result, btn = $(this);
            btn.attr('disabled', '');

            var sql_where=null,sql_select=null, sql_query=null, sql_headers=[], rpt_tbl=null;
            if($("#headers_raw").val() != ''){
                sql_select  = $("#select_query").val();
                sql_headers = $("#headers_raw").val().split(',');
            }else{
                $.notify('Enter report Columns', 'error');
            }
            rpt_tbl = $("#report_table_raw").val();
            if($("#where_query_raw").val() != ''){
                sql_where = $("#where_query_raw").val();
            }else sql_where = '1';

            if(rpt_tbl == 'customers'){
                sql_query = 'SELECT '+sql_select+' FROM customers ' +
                    'WHERE '+sql_where;
            }else if(rpt_tbl == 'vehicles'){
                sql_query = 'SELECT '+sql_select+' FROM vehicles ' +
                    'JOIN customers ON customers.id=vehicles.customer_id ' +
                    'WHERE '+sql_where;
            }else if(rpt_tbl == 'transactions'){
                sql_query = 'SELECT '+sql_select+' FROM transactions ' +
                    'JOIN customers ON customers.id=transactions.customer_id ' +
                    'JOIN vehicles ON vehicles.id=transactions.vehicle_id ' +
                    'WHERE '+sql_where;
            }else if(rpt_tbl == 'sessions'){
                sql_query = 'SELECT '+sql_select+' FROM sessions ' +
                    'WHERE '+sql_where;
            }else{
                $.notify('Select report Table', 'error');
            }

            if(rpt_tbl != null && sql_select != null && sql_headers != [])
                preview_data(sql_headers, sql_query, $("#params").val().split(','));
            else btn.removeAttr('disabled');
        });
        $("#save_report_raw").click(function (){
            var result, btn = $(this);
            var title = $("#title_raw").val(), table = $("#report_table_raw").val();
            var headers=$("#headers_raw").val().split(','), columns=$("#select_query").val(), query=$("#where_query_raw").val(), params=$("#params").val().split(',');
            if(headers == [] || columns == ''){
                $.notify('Enter report Columns/Headers', 'error');
            }
            // title, table, headers, columns, query, params
            if(title != '' && table != '' && headers != [] && columns != null)
            {
                headers = JSON.stringify(headers);
                params = JSON.stringify(params);
                btn.html('Saving...');
                $.ajax({
                    url: "{{ route('reports.save_report') }}",
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", type: "raw", title: title, table: table, headers: headers, columns: columns, query: query, params: params}
                }).done( function (res){
                    if(res.status == 'success'){
                        $.notify('Report Saved Successfully!', 'success');
                        btn.html('Update Report'); btn.removeAttr('disabled');
                    }else if(res.status == 'updated'){
                        $.notify('Report updated Successfully!', 'success');
                        btn.removeAttr('disabled');
                    }else if(res.status == 'validation_error'){
                        $.notify('Validation Error, All input are required', 'error');
                        btn.removeAttr('disabled');
                    }
                })
            }else{
                $.notify('All Field are required.', 'error');
                btn.removeAttr('disabled'); btn.html('Save Report');
            }
        });
        $("#preview_report").click(function (){
            var result, btn = $(this);
            btn.attr('disabled', '');

            try{
                result = $('#builder').queryBuilder('getSQL', 'question_mark');
            }catch(err){
                $.notify('Error - '+err, 'error');
                btn.removeAttr('disabled');
            }

            var sql_select=null, sql_query=null, sql_headers=[], rpt_tbl=null;
            if($("#columns_header").val() != null){
                sql_select = $("#columns_header").val().join(', ');
                $("#columns_header option:selected").each(function (i, e){ sql_headers.push(e.innerHTML) });
            }else{
                $.notify('Select report Columns', 'error');
            }
            rpt_tbl = $("#report_table").val();

            if(rpt_tbl == 'customers'){
                sql_query = 'SELECT '+sql_select+' FROM customers ' +
                    'WHERE '+result.sql;
            }else if(rpt_tbl == 'vehicles'){
                sql_query = 'SELECT '+sql_select+' FROM vehicles ' +
                    'JOIN customers ON customers.id=vehicles.customer_id ' +
                    'WHERE '+result.sql;
            }else if(rpt_tbl == 'transactions'){
                sql_query = 'SELECT '+sql_select+' FROM transactions ' +
                    'JOIN customers ON customers.id=transactions.customer_id ' +
                    'JOIN vehicles ON vehicles.id=transactions.vehicle_id ' +
                    'WHERE '+result.sql;
            }else if(rpt_tbl == 'sessions'){
                sql_query = 'SELECT '+sql_select+' FROM sessions ' +
                    'WHERE '+result.sql;
            }else{
                $.notify('Select report Table', 'error');
            }

            if(result != null && rpt_tbl != null && sql_select != null)
                preview_data(sql_headers, sql_query, result.params);
            else btn.removeAttr('disabled');
        });
        $("#save_report").click(function (){
            var result, btn = $(this);
            btn.attr('disabled', ''); btn.html('Validating...');
            try{
                result = $('#builder').queryBuilder('getSQL', 'question_mark');
            }catch(err){
                $.notify('Error - '+err, 'error');
                btn.removeAttr('disabled'); btn.html('Save Report');
            }
            var title = $("#title").val(), table = $("#report_table").val();
            var headers=[], columns, query=result.sql, params=JSON.stringify(result.params);
            if($("#columns_header").val() != null){
                columns = $("#columns_header").val().join(', ');
                $("#columns_header option:selected").each(function (i, e){ headers.push(e.innerHTML); });
                headers = JSON.stringify(headers);
            }else{
                $.notify('Select report Columns.', 'error');
            }
            // title, table, headers, columns, query, params
            if(title != '' && table != '' && result != null && columns != null)
            {
                btn.html('Saving...');
                $.ajax({
                    url: "{{ route('reports.save_report') }}",
                    type: "POST",
                    data: {"_token": "{{ csrf_token() }}", type: "gui", title: title, table: table, headers: headers, columns: columns, query: query, params: params}
                }).done( function (res){
                    if(res.status == 'success'){
                        $.notify('Report Saved Successfully!', 'success');
                        btn.html('Update Report'); btn.removeAttr('disabled');
                    }else if(res.status == 'updated'){
                        $.notify('Report updated Successfully!', 'success');
                        btn.removeAttr('disabled');
                    }else if(res.status == 'validation_error'){
                        $.notify('Validation Error, All input are required', 'error');
                        btn.removeAttr('disabled');
                    }
                })
            }else{
                $.notify('All Field are required.', 'error');
                btn.removeAttr('disabled'); btn.html('Save Report');
            }
        });

        function preview_data(headers, sql_query, params) {
            var html, header_html;

            header_html += '<tr>';
            $.each(headers, function (i, v){
                header_html += '<th>'+v+'</th>';
            });
            header_html += '</tr>';
            $("#preview_tbl thead").html(header_html);

            $.ajax({
                url: "{{ route('reports.raw_query') }}",
                type: "POST",
                data: {"_token": "{{ csrf_token() }}", sql_query: sql_query, params:params}
            }).done(function (res){
                if(res.hasOwnProperty('error')){
                    $("#errorModal").modal('show');
                    $("#error_content").html(JSON.stringify(res.error));
                }else{
                    $("#preview_tbl tbody").html('');
                    $.each(res, function (i, v){
                        html = '<tr>';
                        $.each(v, function (x, z){
                            html += '<td>'+z+'</td>';
                        });
                        html += '</tr>';
                        $("#preview_tbl tbody").append(html);
                    });
                }
            }).complete(function (){
                $("#preview_report").removeAttr('disabled');
                $("#preview_report_raw").removeAttr('disabled');
            });
        }

        var session_filter = [
            {id: 'user_id', field:"sessions.user_id", label: 'User ID', type: 'string'},
            {id: 'ip_addr', field:"sessions.ip_addr", label: 'IP Addr', type: 'string'},
            {id: 'client', field:"sessions.client", label: 'Client', type: 'string'},
            {id: 'operating_system', field:"sessions.operating_system", label: 'OS', type: 'string'},
            {id: 'device', field:"sessions.device", label: 'Device', type: 'string'},
            {id: 'brand_name', field:"sessions.brand_name", label: 'Brand', type: 'string' },
            {id: 'model', field:"sessions.model", label: 'Model', type: 'string'},
            {id: 'created_at', field:"sessions.created_at", label: 'created_at', type: 'date'},
        ];

        var customer_filter = [
            {id: 'name', field:"customers.name", label: 'Name', type: 'string'},
            {id: 'mobile1', field:"customers.mobile1", label: 'Mobile 1', type: 'string', input: 'number',},
            {id: 'mobile2', field:"customers.mobile2", label: 'Mobile 2', type: 'string', input: 'number',},
            {id: 'email', field:"customers.email", label: 'Email', type: 'string'},
            {id: 'city', field:"customers.city", label: 'City', type: 'string'},
            {id: 'address', field:"customers.address", label: 'Address', type: 'string' },
            {id: 'dob', field:"customers.dob", label: 'DOB', type: 'date'},
            {id: 'autocard', field:"customers.autocard", label: 'Autocard', type: 'boolean', input: 'radio',values: ["No", "Yes"]},
        ];
        var vehicle_filter = [
            // Customer Columns
            {id: 'name', field:"customers.name", label: 'Name', type: 'string'},
            {id: 'mobile1', field:"customers.mobile1", label: 'Mobile 1', type: 'string', input: 'number',},
            {id: 'mobile2', field:"customers.mobile2", label: 'Mobile 2', type: 'string', input: 'number',},
            {id: 'email', field:"customers.email", label: 'Email', type: 'string'},
            {id: 'city', field:"customers.city", label: 'City', type: 'string'},
            {id: 'address', field:"customers.address", label: 'Address', type: 'string' },
            {id: 'dob', field:"customers.dob", label: 'DOB', type: 'date'},
            {id: 'autocard', field:"customers.autocard", label: 'Autocard', type: 'boolean', input: 'radio',values: ["No", "Yes"]},
            // Vehicle Columns
            {id: 'reg_no', field:"vehicles.reg_no", label: 'Reg No.', type: 'string'},
            {id: 'chassis_no', field:"vehicles.chassis_no", label: 'Chassis No', type: 'string', input: 'number'},
            {id: 'engine_no', field:"vehicles.engine_no", label: 'Engine No', type: 'string', input: 'number'},
            {id: 'model', field:"vehicles.model", label: 'Model', type: 'string', input: 'select', values: {!! file_get_contents(storage_path('app/vehicle_models.json')) !!}},
            {id: 'variant', field:"vehicles.variant", label: 'Variant', type: 'string'},
            {id: 'mfgyear', field:"vehicles.mfgyear", label: 'Mfg. Year', type: 'integer', input: 'number'},
            {id: 'mi', field:"vehicles.mi", label: 'MI', type: 'string', input: 'radio', values: ['No', 'Yes']},
            {id: 'finance', field:"vehicles.finance", label: 'Finance', type: 'string', input: 'radio', values: ['No', 'Yes']},
            {id: 'fuel', field:"vehicles.fuel", label: 'Fuel', type: 'string', input: 'radio', values: ['No', 'Yes']},
            {id: 'insurance', field:"vehicles.insurance", label: 'Insurance', type: 'string'},
            {id: 'warranty', field:"vehicles.warranty", label: 'Warranty', type: 'string'},
            {id: 'warranty_exp', field:"vehicles.warranty_exp", label: 'Warranty Exp.', type: 'date'},
            {id: 'amc', field:"vehicles.amc", label: 'AMC', type: 'string'},
            {id: 'amc_key', field:"vehicles.amc_exp", label: 'AMC Exp', type: 'date'},
        ];
        var transaction_filter = [
            // Customer Columns
            {id: 'name', field:"customers.name", label: 'Name', type: 'string'},
            {id: 'mobile1', field:"customers.mobile1", label: 'Mobile 1', type: 'string', input: 'number',},
            {id: 'mobile2', field:"customers.mobile2", label: 'Mobile 2', type: 'string', input: 'number',},
            {id: 'email', field:"customers.email", label: 'Email', type: 'string'},
            {id: 'city', field:"customers.city", label: 'City', type: 'string'},
            {id: 'address', field:"customers.address", label: 'Address', type: 'string' },
            {id: 'dob', field:"customers.dob", label: 'DOB', type: 'date'},
            {id: 'autocard', field:"customers.autocard", label: 'Autocard', type: 'boolean', input: 'radio',values: ["No", "Yes"]},
            // Vehicle Columns
            {id: 'reg_no', field:"vehicles.reg_no", label: 'Reg No.', type: 'string'},
            {id: 'chassis_no', field:"vehicles.chassis_no", label: 'Chassis No', type: 'string', input: 'number'},
            {id: 'engine_no', field:"vehicles.engine_no", label: 'Engine No', type: 'string', input: 'number'},
            {id: 'model', field:"vehicles.model", label: 'Model', type: 'string', input: 'select', values: {!! file_get_contents(storage_path('app/vehicle_models.json')) !!}},
            {id: 'variant', field:"vehicles.variant", label: 'Variant', type: 'string'},
            {id: 'mfgyear', field:"vehicles.mfgyear", label: 'Mfg. Year', type: 'integer', input: 'number'},
            {id: 'mi', field:"vehicles.mi", label: 'MI', type: 'string', input: 'radio', values: ['No', 'Yes']},
            {id: 'finance', field:"vehicles.finance", label: 'Finance', type: 'string', input: 'radio', values: ['No', 'Yes']},
            {id: 'fuel', field:"vehicles.fuel", label: 'Fuel', type: 'string', input: 'radio', values: ['No', 'Yes']},
            {id: 'insurance', field:"vehicles.insurance", label: 'Insurance', type: 'string'},
            {id: 'warranty', field:"vehicles.warranty", label: 'Warranty', type: 'string'},
            {id: 'warranty_exp', field:"vehicles.warranty_exp", label: 'Warranty Exp.', type: 'date'},
            {id: 'amc', field:"vehicles.amc", label: 'AMC', type: 'string'},
            {id: 'amc_key', field:"vehicles.amc_exp", label: 'AMC Exp', type: 'date'},
            // Transaction Filter
            {id: 'transaction_date', field:"transactions.transaction_date", label: 'T Date', type: 'date'},
            {id: 'transaction_type', field:"transactions.transaction_type", label: 'T Type', type: 'string', input: 'select', values: {!! file_get_contents(storage_path('app/transaction_types.json')) !!} },
            {id: 'amount', field:"transactions.amount", label: 'Amount', type: 'string', input: 'number'},
            {id: 'mobile', field:"transactions.mobile", label: 'T Mobile', type: 'string', input: 'number'},
            {id: 'rating', field:"transactions.rating", label: 'Rating', type: 'string'},
            {id: 'remark', field:"transactions.remark", label: 'Remark', type: 'string'},
        ];
        $("#report_table").on('change', function() {
            var v = $(this).val();
            $('#builder').queryBuilder('destroy');
            $("#columns_header").html('');
            if (v == 'customers') {
                $.each(customer_filter, function (i, v){
                    $("#columns_header").append("<option value='"+v.field+"'>"+v.label+"</option>")
                });

                $('#builder').queryBuilder({
                    plugins: ['bt-tooltip-errors'],
                    filters: customer_filter,
                    rules: rules_basic,
                });
            } else if (v == 'vehicles') {
                $.each(vehicle_filter, function (i, v){
                    $("#columns_header").append("<option value='"+v.field+"'>"+v.label+"</option>")
                });

                $('#builder').queryBuilder({
                    plugins: ['bt-tooltip-errors'],
                    filters: vehicle_filter,
                    rules: rules_basic,
                });
            } else if (v == 'transactions'){
                $.each(transaction_filter, function (i, v){
                    $("#columns_header").append("<option value='"+v.field+"'>"+v.label+"</option>")
                });

                $('#builder').queryBuilder({
                    plugins: ['bt-tooltip-errors'],
                    filters: transaction_filter,
                    rules: rules_basic,
                });
            } else if (v == 'sessions'){
                $.each(session_filter, function (i, v){
                    $("#columns_header").append("<option value='"+v.field+"'>"+v.label+"</option>")
                });

                $('#builder').queryBuilder({
                    plugins: ['bt-tooltip-errors'],
                    filters: session_filter,
                    rules: {
                        condition: 'AND',
                        rules: [{
                            id: 'user_id',
                            operator: 'is_not_null'
                        }]
                    },
                });
            }
            $("#columns_header").select2();
        });
    </script>
@endsection