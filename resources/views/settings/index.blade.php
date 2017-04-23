@extends('app')

@section('content')
    @include('partials.page_header', ['title'=>"Application Settings", 'desc'=>""])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Settings</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" data-ctarget="customer_form" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <form class="form-horizontal" method="post" action="{{ route('settings.save') }}">
                    <fieldset>
                    {!! csrf_field() !!}
                    <!-- Textarea -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="vehicle_models">Vehicle Models</label>
                            <div class="col-md-4">
                                <textarea class="form-control" id="vehicle_models" name="vehicle_models">{!! implode(',', json_decode(file_get_contents(storage_path('app/vehicle_models.json')))) !!}</textarea>
                            </div>
                        </div>

                        <!-- Textarea -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="transaction_types">Transaction Types</label>
                            <div class="col-md-4">
                                <textarea class="form-control" id="transaction_types" name="transaction_types">{!! implode(',', json_decode(file_get_contents(storage_path('app/transaction_types.json')))) !!}</textarea>
                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="save"></label>
                            <div class="col-md-4">
                                <button id="save" name="save" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>

            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>

    </script>
@endsection