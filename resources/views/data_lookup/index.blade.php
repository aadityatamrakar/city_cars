@extends('app')

@section('content')
    @include('partials.page_header', ['title'=>"Data Lookup", 'desc'=>"Vehicles Lookup"])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Search in Data</h3>
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
                        <td><input style="width: 50px;" type="text" class="form-control" /></td>
                        <td><input style="width: 160px;" type="text" class="form-control" /></td>
                        <td><input style="width: 80px;" type="text" class="form-control" /></td>
                        <td><input style="width: 80px;" type="text" class="form-control" /></td>
                        <td><input style="width: 120px;" type="text" class="form-control" /></td>
                        <td><input style="width: 80px;" type="text" class="form-control" /></td>
                        <td><input style="width: 80px;" type="text" class="form-control" /></td>
                        <td><input style="width: 60px;" type="text" class="form-control" /></td>
                        <td><input style="width: 60px;" type="text" class="form-control" /></td>
                        <td><input style="width: 80px;" type="text" class="form-control" /></td>
                        <td><input style="width: 60px;" type="text" class="form-control" /></td>
                        <td><input style="width: 110px;" type="text" class="form-control" /></td>
                        <td><input style="width: 60px;" type="text" class="form-control" /></td>
                        <td><input style="width: 80px;" type="text" class="form-control" /></td>
                        <td><input style="width: 60px;" type="text" class="form-control" /></td>
                        <td><input style="width: 60px;" type="text" class="form-control" /></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $('#data_lookup_tbl').DataTable({
            processing: true,
            serverSide: true,
            scrollX: true,
            columnDefs: [
                { width: '20%', targets: 1 },
            ],
            fixedColumns: true,
            ajax: '{{ route('datatables_ajax.vehicles') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'customer.name', name: 'customer.name'},
                {data: 'customer.mobile1', name: 'customer.mobile1'},
                {data: 'customer.city', name: 'customer.city'},
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
            ],
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    $(column.footer()).children(0)
                        .on('keyup change', function () {
                            var val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? val : '', true, false).draw();
                        });
                });
            }
        });
    </script>
@endsection