@extends('app')

@section('content')
    @include('partials.page_header', ['title'=>"Session Info", 'desc'=>"User Login Details"])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">User Login Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" data-ctarget="customer_form" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped" id="data_lookup_tbl">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>IP Details</th>
                        <th>Time</th>
                        <th>Client</th>
                        <th>OS</th>
                        <th>Device</th>
                        <th>Brand Name</th>
                        <th>Model</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @include('partials.dt_conf_js', ["table_id"=>"data_lookup_tbl", "route"=>"datatables_ajax.sessions", "columns"=>"
    columns: [
        {data: 'sid', name: 'sessions.id'},
        {data: 'name', name: 'users.name'},
        {data: 'mobile', name: 'users.mobile'},
        {data: 'email', name: 'users.email'},
        {data: 'ip_addr', name: 'ip_addr'},
        {data: 'created_at', name: 'created_at'},
        {data: 'client', name: 'client'},
        {data: 'operating_system', name: 'operating_system'},
        {data: 'device', name: 'device'},
        {data: 'brand_name', name: 'brand_name'},
        {data: 'model', name: 'model'},
    ],"])
@endsection