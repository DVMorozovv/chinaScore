{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','home')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/animate-css/animate.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
@endsection

{{-- page content --}}
@section('content')

{{--    @dump($article)--}}

<div class="section">
    <div class="card">
        <div class="card-content">
            <h4 class="card-title">{{$article->heading}}</h4>
            <div class="row">
                <div class="col l8">
                    <p class="caption mb-0">{{$article->content}}</p>
                </div>
                <div class="col l4">
                    <img src="/storage/images/articles/{{$article->image}}">
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/sortable/jquery-sortable-min.js')}}"></script>
    <script src="{{asset('vendors/quill/quill.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')

@endsection
