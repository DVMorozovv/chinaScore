{{-- layout extend --}}
@extends('layouts.adminLayoutMaster')

{{-- page title --}}
@section('title','Main')

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
@endsection

{{-- page content --}}
@section('content')

    <h1>Admin Page</h1>

@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/sortable/jquery-sortable-min.js')}}"></script>
    <script src="{{asset('vendors/quill/quill.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')

@endsection
