@extends('app')

@section('pagetitle', 'City Cars App - View Reports')

@section('content')
    @include('partials.page_header', ['title'=>"Reports Generator", 'desc'=>""])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">View Reports</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">

                <table class="table table-striped" id="tbl">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(App\Report::all() as $report)
                            <tr>
                                <td>{{ $report->id }}</td>
                                <td>{{ $report->title }}</td>
                                <td>
                                    <a class="btn btn-xs btn-default" target="new" href="{{ route('reports.pivot', ['id'=>$report->id]) }}"><i class="fa fa-file-o"></i> Pivot</a>
                                    <a class="btn btn-xs btn-default" target="new" href="{{ route('reports.generator', ['id'=>$report->id]) }}"><i class="fa fa-file-o"></i> View</a>
                                    <a class="btn btn-xs btn-default" target="new" href="{{ route('reports.download', ['id'=>$report->id]) }}"><i class="fa fa-download"></i> Download</a>
                                    <a class="btn btn-xs btn-default" target="new" href="{{ route('reports.mail', ['id'=>$report->id]) }}"><i class="fa fa-envelope"></i> Mail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $("#tbl").dataTable();
    </script>
@endsection