{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','home')

{{-- vendor styles --}}
@section('vendor-style')
    {{--<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">--}}
    {{--<link rel="stylesheet" type="text/css" href="{{asset('vendors/quill/quill.snow.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/animate-css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/chartist-js/chartist.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/chartist-js/chartist-plugin-tooltip.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-email.css')}}">
@endsection

{{-- page content --}}
@section('content')

{{--    @dump($article)--}}

    <section class="container">
        <h4 class="mb-2">{{$article->heading}}</h4>
        <div class="card-image">
            <img src="/storage/images/articles/{{$article->image}}">
        </div>
        <div class="card-text mb-2">
            <p class="">{{$article->content}}</p>
        </div>
    </section>

@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/sortable/jquery-sortable-min.js')}}"></script>
    <script src="{{asset('vendors/quill/quill.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')

@endsection
