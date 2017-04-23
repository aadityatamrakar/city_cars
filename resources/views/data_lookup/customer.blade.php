@extends('app')
@section('pagetitle', 'City Cars App - Customers')
@section('content')
    @include('partials.page_header', ['title'=>"Data Lookup", 'desc'=>"Customers Lookup"])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Search in Customers Data</h3>
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
                        <th>Mobile 1</th>
                        <th>Mobile 2</th>
                        <th>Dob</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Address</th>
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
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal" id="mergeCustomer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Merge Customer</h4>
                </div>
                <div class="modal-body">
                    <form id="merge_cust_form" class="form-horizontal" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-4" for="merge_id">Customer ID</label>
                                <div class="col-md-4">
                                    <input type="number" readonly class="form-control" name="cust_id" id="cust_id" value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4" for="merge_id">Merge with ID</label>
                                <div class="col-md-4">
                                    <input type="number" class="form-control" name="merge_id" id="merge_id" />
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-target="update_merge">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('partials.dt_conf_js', ['table_id'=>'data_lookup_tbl', "route"=>'datatables_ajax.customers', 'columns'=>"columns: [
        {data: 'id', name: 'id', render:
            function (data, type, full, meta){
                return '<button data-id=\"'+data+'\" data-toggle=\"modal\" data-target=\"#mergeCustomer\" class=\"btn btn-xs btn-default\"><i class=\"glyphicon glyphicon-pencil\"></i> '+data+'</a>';
            }
        },
        {data: 'name', name: 'name', render:
            function (data, type, full, meta){
                return '<a href=\"/data_entry/edit/'+full.id+'\">'+data+'</a>';
            }
        },
        {data: 'mobile1', name: 'mobile1'},
        {data: 'mobile2', name: 'mobile2'},
        {data: 'dob', name: 'dob'},
        {data: 'email', name: 'email'},
        {data: 'city', name: 'city'},
        {data: 'address', name: 'address'},
    ],"])

    <script>
        $('#mergeCustomer').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var cust_id = button.data('id') // Extract info from data-* attributes
            $('#cust_id').val(cust_id)
            $('#merge_id').val('')
        })

        $('[data-target="update_merge"]').click(function (){
            $('#mergeCustomer').modal('hide');
            var form_data = $("#merge_cust_form").serializeArray();
            $.ajax({
                url:"{{ route('data_entry.merge', ['type'=>'customer']) }}",
                type: 'POST',
                async: true,
                data: form_data
            }).done(function (res){
                if(res.status == 'ok'){
                    $.notify('Merged Successfully!', 'success');
                    dtbl.ajax.reload();
                }else{
                    $.notify('Merged Failed.', 'error');
                }
            })
        });
    </script>
@endsection