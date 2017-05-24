@extends('app')

@section('styles')
    <style>
        .notifyjs-foo-base {
            opacity: 0.85;
            width: 200px;
            background: #F5F5F5;
            padding: 5px;
            border-radius: 10px;
        }

        .notifyjs-foo-base .title {
            width: 100px;
            float: left;
            margin: 10px 0 0 10px;
            text-align: right;
        }

        .notifyjs-foo-base .buttons {
            width: 70px;
            float: right;
            font-size: 9px;
            padding: 5px;
            margin: 2px;
        }

        .notifyjs-foo-base button {
            font-size: 9px;
            padding: 5px;
            margin: 2px;
            width: 60px;
        }
    </style>
@endsection

@section('content')
    @include('partials.page_header', ['title'=>"Data Entry", 'desc'=>isset($customer)?"Update Customer Records":''])

    <section class="content">
        <!-- Customer Form Start -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Customer Form {{ isset($customer)?"- Update":'' }}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" data-ctarget="customer_form" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div id="form_errors"></div>
                @include('data_entry.customer_form', ['customer'=>isset($customer)?$customer:new \App\Customer() ])
            </div>
        </div>
        <!-- Customer Form End -->

        <div class="row {!! isset($customer)?'':'hide' !!}" id="extra_details">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Vehicles</h3>
                        <div class="box-tools pull-right">
                            <button data-toggle="modal" data-target="#addVehicle" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Add New Vehicle</button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped" id="vehicle_tbl">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Reg.No</th>
                                <th>Model</th>
                                <th>MfgYear</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( isset($customer) )
                                @foreach($customer->vehicles as $vehicle)
                                    <tr data-row="{{ $vehicle->id }}">
                                        <td>
                                            <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addVehicle" data-vehicle='{!! urlencode(json_encode($vehicle)) !!}'>
                                                <i class="fa fa-edit"></i> {{ $vehicle->id }}
                                            </button>
                                        </td>
                                        <td>{{ $vehicle->reg_no }}</td>
                                        <td>{{ $vehicle->model }}</td>
                                        <td>{{ $vehicle->mfgyear }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Transactions</h3>
                        <div class="box-tools pull-right">
                            <button data-toggle="modal" data-target="#addTransactions" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Add New Transaction</button>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-striped" id="transaction_tbl">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Vehicle</th>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( isset($customer) )
                                @foreach($customer->transactions as $t)
                                    <tr data-row="{{ $t->id }}">
                                        <td>
                                            <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#addTransactions" data-transaction='{!! urlencode(json_encode($t)) !!}' data-vid="{{ $t->vehicle_id }}">
                                                <i class="fa fa-edit"></i> {{ $t->id }}
                                            </button>
                                        </td>
                                        <td>{{ $t->vehicle->reg_no.' - '.$t->vehicle->model }}</td>
                                        <td>{{ $t->transaction_date->format('d/m/Y') }}</td>
                                        <td>{{ $t->transaction_type }}</td>
                                        <td>{{ $t->amount }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle Modal Start -->
        <div class="modal fade" id="addVehicle" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add New Vehicle</h4>
                    </div>
                    <div class="modal-body">
                        @include('data_entry.vehicle_form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="vehicle_save">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Vehicle Modal End -->

        <!-- Transaction Modal Start -->
        <div class="modal fade" id="addTransactions" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Add New Transaction</h4>
                    </div>
                    <div class="modal-body">
                        @include('data_entry.transaction_form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="transaction_save">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Transaction Modal End -->
    </section>
@endsection

@section('scripts')
    <script>
        var customer_id {!! isset($customer)?'='.$customer->id:'' !!}, token="{{ csrf_token() }}";

        // Datepicker Initialize
        $(document).ready(function (){
            $('#dob').datepicker();
            $('#insurance').datepicker();
            $('#warranty_exp').datepicker();
            $('#amc_exp').datepicker();
            $('#transaction_date').datepicker();
        });

        // Customer Add Form Submit
        $("#customer_form").on('submit', function (e){
            e.preventDefault();
            $("#save").attr('disabled', '');
            $("#save").html('Saving...');
            clear_validation();
            var form_data = $(this).serializeArray();
            if(customer_id != null && customer_id != '') form_data[form_data.length] = {name: "customer_id", value: customer_id};
            $.ajax({
                url: "{{ route('customer_entry') }}",
                type: "POST",
                data: form_data
            }).done(function (res){
                if(res['status'] == 'success'){
                    customer_id = res['customer_id'];
                    $.notify("Customer Saved Successfully!", 'success');
                    $("#save").html('Update');
                    $("#save").removeAttr('disabled');
                    $('[data-ctarget="customer_form"]').trigger('click');
                    $("#extra_details").removeClass('hide');
                }else if(res['status'] == 'validation_failed'){
                    $.notify("Errors!", 'error');
                    show_validation(res.validator);
                    $("#save").html('Save');
                    $("#save").removeAttr('disabled');
                }else if(res['status'] == 'updated'){
                    $.notify("Customer Updated Successfully!", 'success');
                    $("#save").html('Update');
                    $("#save").removeAttr('disabled');
                }
            });
        });

        // Vehicle Adding Modal Submit
        $('#addVehicle').on('show.bs.modal', function (event) {
            var modal = $(this);
            var btn = $(event.relatedTarget);
            modal.find('.modal-title').text('Add New Vehicle');
            modal.find('input[name="_token"]').val(token);
            if(customer_id != null && customer_id != ''){
                modal.find('#customer_id').val(customer_id);
            }else{
                event.preventDefault();
                $.notify('Customer ID not found.', 'error');
            }
            if((vehicle=btn.data('vehicle')) != null){
                vehicle = JSON.parse(decodeURIComponent(vehicle));
                modal.find('#vehicle_id').val(vehicle.id);
                modal.find('#reg_no').val(vehicle.reg_no);
                modal.find('#chassis_no').val(vehicle.chassis_no);
                modal.find('#engine_no').val(vehicle.engine_no);
                modal.find('#model').val(vehicle.model.toUpperCase());
                modal.find('#variant').val(vehicle.variant);
                modal.find('#mfgyear').val(vehicle.mfgyear);
                modal.find('#mi[value="'+vehicle.mi+'"]').trigger('click');
                modal.find('#finance').val(vehicle.finance.toUpperCase());
                modal.find('#fuel[value="'+vehicle.fuel+'"]').trigger('click');
                if(vehicle.insurance != null) modal.find('#insurance').val(moment(vehicle.insurance).format('DD/MM/YYYY'));
                modal.find('#warranty').val(vehicle.warranty);
                if(vehicle.warranty_exp != null) modal.find('#warranty_exp').val(moment(vehicle.warranty_exp).format('DD/MM/YYYY'));
                modal.find('#amc[value="'+vehicle.amc+'"]').trigger('click');
                if(vehicle.amc_exp != null) modal.find('#amc_exp').val(moment(vehicle.amc_exp).format('DD/MM/YYYY'));
            }
        });
        $("#vehicle_save").on('click', function (e){
            e.preventDefault();
            $("#vehicle_save").attr('disabled', '');
            clear_validation();
            var form_data = $("#vehicle_form").serializeArray();
            $.ajax({
                url: "{{ route('vehicle_entry') }}",
                type: "POST",
                data: form_data
            }).done(function (res){
                if(res['status'] == 'success'){
                    $.notify("Vehicle Saved Successfully!", 'success');
                    $("#vehicle_save").removeAttr('disabled');
                    var new_row = "<tr><td>"+res['vehicle_id']+"</td><td><button data-toggle='modal' data-target='#addTransactions' data-vid='"+res['vehicle_id']+"' class=\"btn btn-xs btn-primary\">"+res['vehicle']['reg_no']+"</button></td><td>"+res['vehicle']['model']+"</td><td>"+res['vehicle']['mfgyear']+"</td></tr>";
                    $("#vehicle_tbl tbody").append(new_row);
                    $("#addVehicle").modal('hide');
                }else if(res['status'] == 'validation_failed'){
                    $.notify("Errors!", 'error');
                    show_validation(res.validator);
                    $("#vehicle_save").removeAttr('disabled');
                }else if(res['status'] == 'updated'){
                    vehicle = res.vehicle;
                    $.notify("Vehicle Updated Successfully!", 'success');
                    $("#vehicle_save").removeAttr('disabled');
                    $("#addVehicle").modal('hide');
                    setTimeout(function (){
                        window.location.reload();
                    }, 700);
                }
            });
        });
        $('#addVehicle').on('hidden.bs.modal', function (event) {
            $('#vehicle_form input[type="text"]').val('');
            $("#vehicle_form select").val('--select--');
            $('#vehicle_form #vehicle_id').val('');
        });

        // Transaction Add Modal Submit
        $('#addTransactions').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var vid = button.data('vid');
            var modal = $(this);
            var vehicles = [];
            modal.find('.modal-title').text('Add New Transaction');
            modal.find('input[name="_token"]').val(token);
            if(customer_id != null && customer_id != ''){
                modal.find('#customer_id').val(customer_id);
            }else{
                event.preventDefault();
                $.notify('Customer ID not found.', 'error');
            }

            $("#transaction_form #vehicle_id").attr('disabled', '');
            $.ajax({
                url: "{{ route('customer_vehicles') }}",
                type: "POST",
                data: {"_token":token, "customer_id":customer_id}
            }).done(function (res){
                if(res.length > 0)
                {
                    $("#transaction_form #vehicle_id").html('');
                    $.each(res, function (i, v){
                        $("#transaction_form #vehicle_id").append('<option value="'+v['id']+'">'+v['reg_no']+' - '+v['model']+'</option>');
                        vehicles.push({id: v['id'], text: v['reg_no']+' - '+v['model']});
                    });
                    if(vehicles.length > 0){
                        // $("#vehicle_id").append({data: vehicles});
                        if(vid != null) $("#transaction_form #vehicle_id").val(vid).trigger('change');
                        $("#transaction_form #vehicle_id").select2();
                    }else{
                        event.preventDefault();
                        $.notify('No Vehicle found.', 'error');
                    }
                }
                $("#transaction_form #vehicle_id").removeAttr('disabled');
            });

            if((t=button.data('transaction')) != null)
            {
                t = JSON.parse(decodeURIComponent(t));
                modal.find('#transaction_id').val(t.id);
                modal.find('#transaction_date').val(moment(t.transaction_date).format('DD/MM/YYYY'));
                modal.find('#transaction_type').val(t.transaction_type.toUpperCase());
                modal.find('#amount').val(t.amount);
                modal.find('#rating').val(t.rating);
                modal.find('#remark').val(t.remark);
                modal.find('#mobile').val(t.mobile);
            }
        });
        $("#transaction_save").on('click', function (e){
            e.preventDefault();
            $("#transaction_save").attr('disabled', '');
            clear_validation();
            var form_data = $("#transaction_form").serializeArray();
            $.ajax({
                url: "{{ route('transaction_entry') }}",
                type: "POST",
                data: form_data
            }).done(function (res){
                if(res['status'] == 'success'){
                    $.notify("Transaction Saved Successfully!", 'success');
                    $("#transaction_save").removeAttr('disabled');
                    var new_row = "<tr><td>"+res['transaction']['id']+"</td><td>"+res['transaction']['vehicle']['reg_no']+" - "+res['transaction']['vehicle']['model']+"</td><td>"+moment(res['transaction']['transaction_date']).format('DD/MM/Y')+"</td><td>"+res['transaction']['transaction_type']+"</td><td>"+res['transaction']['amount']+"</td></tr>";
                    $("#transaction_tbl tbody").append(new_row);
                    $("#addTransactions").modal('hide');
                }else if(res['status'] == 'validation_failed'){
                    $.notify("Errors!", 'error');
                    show_validation(res.validator);
                    $("#transaction_save").removeAttr('disabled');
                }else if(res['status'] == 'updated'){
                    $.notify("Transaction Updated Successfully!", 'success');
                    window.location.reload();
                }
            });
        });
        $('#addTransactions').on('hidden.bs.modal', function (event) {
            $('#transaction_form input[type="text"]').val('');
            $("#transaction_form select").val('--select--');
            $("#transaction_form #remark").html('');
            $('#transaction_form #transaction_id').val('');
        });

        // Functions
        @if(Route::currentRouteName() == 'data_entry')
        $('[data-toggle="check_duplicate"]').on('blur', function (e){
            var column = $(this).attr('name');
            var val = $(this).val();
            var table = $(this).data('table');
            if(val.length > 0)
            {
                $.ajax({
                    url: "{{ route('duplicate_check') }}",
                    type: "POST",
                    data: {table: table, column: column, value: val, '_token': "{{ csrf_token() }}"}
                }).done(function (res) {
                    if (res['status'] == 'found') {
                        if (table == 'customers') {
                            $.notify({
                                title: 'Duplicate Found! Goto previous record ?',
                                button: 'Confirm',
                                customer_id: res['customer']['id']
                            }, {
                                style: 'foo',
                                autoHide: false,
                                clickToHide: false
                            });
                        }
                        else if (table == 'vehicles') {
                            $.notify({
                                title: 'Duplicate Found! Goto previous record ?',
                                button: 'Confirm',
                                customer_id: res['vehicle']['id']
                            }, {
                                style: 'foo',
                                autoHide: true,
                                clickToHide: false
                            });
                        }
                    }
                })
            }
        });

        $.notify.addStyle('foo', {
            html:
            "<div>" +
            "<div class='clearfix'>" +
            "<div class='title' data-notify-html='title'/>" +
            "<div class=\"hide\" id=\"customer_id\" data-notify-text='customer_id' />" +
            "<div class='buttons'>" +
            "<button class='no'>Cancel</button>" +
            "<button class='yes' data-notify- data-notify-text='button'></button>" +
            "</div>" +
            "</div>" +
            "</div>"
        });
        $(document).on('click', '.notifyjs-foo-base .no', function() {
            $(this).trigger('notify-hide');
        });
        $(document).on('click', '.notifyjs-foo-base .yes', function() {
            window.location = '{{ route('data_entry.edit', ['id'=>''])}}/'+$('.notifyjs-foo-base #customer_id').text();
            $(this).trigger('notify-hide');
        });
        @endif

        function show_validation(validator){
            $.each(validator, function (item, errors){
                $("#"+item).parent().children(1).html(errors[0]);
                $("#"+item).parent().parent().addClass('has-error');
            });
        }
        function clear_validation(){
            $(".has-error").removeClass('has-error');
            $(".help-block").html('');
        }
    </script>
@endsection