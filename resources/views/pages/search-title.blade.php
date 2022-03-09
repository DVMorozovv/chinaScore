{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','items')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/quill/quill.snow.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-email.css')}}">
@endsection

{{-- page content --}}
@section('content')

    <div class="mb-2 mt-4">
        <h4>Искать по названию</h4>
        <form class="formValidate" action="{{ route('search_form', $id) }}" method="POST">
            @csrf
            <div class="row ">
                <div class="col s10 m11 l11">
                    <input class="form-control" type="text" name="title" id="title" placeholder="Поиск по названию" required minlength="1">
                </div>
                <div class="col s2 m1 l1 center-align mt-1">
                    <button class="waves-effect waves-light btn-floating gradient-45deg-purple-deep-orange" type="submit"><i class="material-icons">search</i></button>
                </div>
            </div>
        </form>
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/sortable/jquery-sortable-min.js')}}"></script>
    <script src="{{asset('vendors/quill/quill.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>

@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>
@endsection
