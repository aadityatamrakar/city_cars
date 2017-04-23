@extends('app')

@section('pagetitle', 'City Cars App - Report Mailing Schedule')

@section('styles')
    <link rel="stylesheet" href="/css/jqCron.css"/>
@endsection

@section('content')
    @include('partials.page_header', ['title'=>"Mailing Setting", 'desc'=>""])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Manage Mailing Schedule</h3>
                <div class="box-tools pull-right">
                    <button type="button" data-toggle="modal" data-target="#mailingModal" class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Add New Mailing</button>
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Report</th>
                        <th>Cron</th>
                        <th>Users</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(\App\Mailing::all() as $mailing)
                        <tr>
                            <td>
                                <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#mailingModal" data-id="{{ $mailing->id }}" data-form_data="{{ urlencode(json_encode($mailing)) }}"><i class="fa fa-pencil"></i> {{ $mailing->id }}</button>
                                <button class="btn btn-xs btn-danger" data-toggle="deleteMailing" data-id="{{ $mailing->id }}"><i class="fa fa-remove"></i> {{ $mailing->id }}</button>
                            </td>
                            <td>{{ $mailing->title }}</td>
                            <td>{{ $mailing->report->title }}</td>
                            <td><span class="cron_job" data-cron="{{ $mailing->cron_job }}">{{ $mailing->cron_job }}</span></td>
                            <td>
                                @foreach(json_decode($mailing->users) as $user)
                                    {{ \App\User::find($user)!=null?\App\User::find($user)->name:'' }},
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>


    <div class="modal fade" id="mailingModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add New Mailing</h4>
                </div>
                <div class="modal-body">
                    @include('mailing.form')
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="/js/jqCron.js"></script>
    <script src="/js/jqCron.en.js"></script>
    <script>
        var cron;
        $(function(){
            cron = $('#cronjob').jqCron({
                enabled_minute: true,
                multiple_dom: true,
                multiple_month: true,
                multiple_mins: false,
                multiple_dow: true,
                multiple_time_hours: false,
                multiple_time_minutes: false,
                default_period: 'week',
                default_value: '30 15 * * 1-5',
                no_reset_button: false,
                lang: 'en',
                bind_to: $('#cron_job'),
                bind_method: {
                    set: function($element, value) {
                        $element.val(value);
                    }
                }
            }).jqCronGetInstance();
            $("#report").select2();
            $(".myselect2").select2();

            $.each($(".cron_job"), function (i, v){
                try{
                    $(v).html(cronParse($(v).data('cron')))
                }catch(e){
                    console.log(e)
                }
            });
        });

        $("#mailingModal").on('show.bs.modal', function (e){
            var btn = $(e.relatedTarget);
            var modal = $(this);
            if(btn.data('id') != null && btn.data('form_data') != null){
                var form_data = JSON.parse(decodeURIComponent(btn.data('form_data')));
                console.log(form_data);
                modal.find('#title').val(form_data['title']);
                modal.find('#report').val(form_data['report_id']).trigger("change");
                cron.setCron(encodeURIComponent(form_data['cron_job']).replaceAll('%2B', ' '));
                modal.find('#users').val(JSON.parse(form_data['users'])).trigger("change");
                modal.find('#mailing_id').val(form_data['id']);
            }else{
                modal.find('#title').val('');
                modal.find('#report').val('').trigger("change");
                cron.setCron(encodeURIComponent("30 15 * * 1-5").replaceAll('%2B', ' '));
                modal.find('#users').val([]).trigger("change");
                modal.find('#mailing_id').val("");
            }
        });

        $("#save").click(function (){
            var btn = $(this);
            var form_data = $("#mailing_form").serializeArray();
            btn.attr('disabled', '');
            $.ajax({
                url: "{{ route('mailing.save') }}",
                type: "POST",
                data: form_data
            }).done(function (res){
                if(res['status'] == 'success'){
                    $.notify('Saved Successfully!', 'success');
                    window.location.reload();
                }if(res['status'] == 'updated'){
                    $.notify('Updated Successfully!', 'success');
                    window.location.reload();
                }else if(res['status'] == 'validation_error'){
                    $.notify('All Fields are required!', 'error');
                }else{
                    $.notify('Something went wrong.', 'error');
                }
            });
        });

        $('[data-toggle="deleteMailing"]').click(function (){
            var id = $(this).data('id');

            if(confirm("Confirm Delete ? "))
            {
                $.ajax({
                    url: "{{ route('mailing.delete') }}",
                    type: "POST",
                    data: {"_token":"{{ csrf_token() }}", id:id}
                }).done(function (res){
                    if(res.status == 'deleted'){
                        $.notify('Delete successfully.', 'info');
                        window.location.reload();
                    }else{
                        $.notify('Error.', 'error');
                    }
                })
            }
        })
    </script>
@endsection