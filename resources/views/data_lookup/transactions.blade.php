@extends('app')
@section('pagetitle', 'City Cars App - Transactions')
@section('content')
    @include('partials.page_header', ['title'=>"Data Lookup", 'desc'=>"Transactions Lookup"])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Search in Transaction Data</h3>
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
                        <th>Customer</th>
                        <th>Mobile</th>
                        <th>City</th>
                        <th>Reg_No</th>
                        <th>Model</th>
                        <th>Variant</th>
                        <th>T Date</th>
                        <th>T Type</th>
                        <th>Amount</th>
                        <th>Mobile</th>
                        <th>Rating</th>
                        <th>Remarks</th>
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
    @include('partials.dt_conf_js', ['table_id'=>'data_lookup_tbl', "route"=>'datatables_ajax.transactions', "columns"=>"columns: [
        {data: 'tid', name: 'transactions.id', render:
            function (data, type, full, meta){
                return '<a href=\"/data_entry/edit/'+full.cid+'\">'+data+'</a>';
            }
        },
        {data: 'name', name: '".env('DB_TBL_PREFIX')."customers.name', render:
            function (data, type, full, meta){
                return '<a href=\"/data_entry/edit/'+full.cid+'\">'+data+'</a>';
            }
        },
        {data: 'mobile1', name: '".env('DB_TBL_PREFIX')."customers.mobile1'},
        {data: 'city', name: '".env('DB_TBL_PREFIX')."customers.city'},
        {data: 'reg_no', name: '".env('DB_TBL_PREFIX')."vehicles.reg_no'},
        {data: 'model', name: '".env('DB_TBL_PREFIX')."vehicles.model'},
        {data: 'variant', name: '".env('DB_TBL_PREFIX')."vehicles.variant'},
        {data: 'transaction_date', name: 'transaction_date'},
        {data: 'transaction_type', name: 'transaction_type'},
        {data: 'amount', name: 'amount'},
        {data: 'mobile', name: 'mobile'},
        {data: 'rating', name: 'rating'},
        {data: 'remark', name: 'remark'},
    ],"]);
@endsection