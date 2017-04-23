@extends('app')
@section('pagetitle', 'City Cars App - Vehicles')
@section('content')
    @include('partials.page_header', ['title'=>"Data Lookup", 'desc'=>"Vehicles Lookup"])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Search in Vehicles Data</h3>
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
                        <th>Customer </th>
                        <th>Mobile</th>
                        <th>City</th>
                        <th>Reg_no</th>
                        <th>Model</th>
                        <th>Variant</th>
                        <th>Year</th>
                        <th>MI</th>
                        <th>Insurance</th>
                        <th>Warranty</th>
                        <th>Warranty Exp.</th>
                        <th>AMC</th>
                        <th>AMC Exp.</th>
                        <th>Finance</th>
                        <th>Fuel</th>
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
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                        <td><input style="width: 100%;" type="text" class="form-control" /></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>

    <div class="modal" id="mergeVehicle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Merge Vehicle</h4>
                </div>
                <div class="modal-body">
                    <form id="merge_veh_form" class="form-horizontal" method="post">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-md-4" for="vehicle_id">Vehicle ID</label>
                                <div class="col-md-4">
                                    <input type="number" readonly class="form-control" name="vehicle_id" id="vehicle_id" value="" />
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
    @include('partials.dt_conf_js', ['table_id'=>'data_lookup_tbl', "route"=>'datatables_ajax.vehicles', "columns"=>"
    columns: [
        {data: 'vid', name: 'vehicles.id', render:
            function (data, type, full, meta){
                return '<button data-id=\"'+data+'\" data-toggle=\"modal\" data-target=\"#mergeVehicle\" class=\"btn btn-xs btn-default\"><i class=\"glyphicon glyphicon-pencil\"></i> '+data+'</a>';
            }
        },
        {data: 'name', name: 'customers.name', render:
            function (data, type, full, meta){
                return '<a href=\"/data_entry/edit/'+full.cid+'\">'+data+'</a>';
            }
        },
        {data: 'mobile1', name: 'customers.mobile1'},
        {data: 'city', name: 'customers.city'},
        {data: 'reg_no', name: 'reg_no'},
        {data: 'model', name: 'model'},
        {data: 'variant', name: 'variant'},
        {data: 'mfgyear', name: 'mfgyear'},
        {data: 'mi', name: 'mi'},
        {data: 'insurance', name: 'insurance'},
        {data: 'warranty', name: 'warranty'},
        {data: 'warranty_exp', name: 'warranty_exp'},
        {data: 'amc', name: 'amc'},
        {data: 'amc_exp', name: 'amc_exp'},
        {data: 'finance', name: 'finance'},
        {data: 'fuel', name: 'fuel'},
    ],"])

    <script>
        $('#mergeVehicle').on('shown.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var cust_id = button.data('id') // Extract info from data-* attributes
            $('#vehicle_id').val(cust_id)
            $('#merge_id').val('')
        })

        $('[data-target="update_merge"]').click(function (){
            $('#mergeVehicle').modal('hide');
            var form_data = $("#merge_veh_form").serializeArray();
            $.ajax({
                url:"{{ route('data_entry.merge', ['type'=>'vehicle']) }}",
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