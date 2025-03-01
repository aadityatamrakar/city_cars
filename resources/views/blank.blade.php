@extends('app')

@section('pagetitle', 'Blank Page')

@section('content')
    @include('partials.page_header', ['title'=>"Blank Page", 'desc'=>"Description"])

    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Heading</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                Content
            </div>
        </div>
    </section>
@endsection