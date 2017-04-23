@extends('app')

@section('pagetitle', 'Access Denied!')

@section('content')
    @include('partials.page_header', ['title'=>"Access Denied", 'desc'=>"Contact Administration"])

    <section class="content">
        <div class="box">
            <div class="box-body">
                Contact your Administrator.
            </div>
        </div>
    </section>
@endsection