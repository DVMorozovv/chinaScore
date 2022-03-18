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
    <h4 class="mt-4 mb-2">Поиск по картинке</h4>
    <p><b>Пример ссылки на картинку:  </b> https://www.google.ru/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png</p>
    <form class="formValidate" action="{{ route('searchPhotoForm') }}" method="POST">
        @csrf
        <div class="row ">
            <div class="col s10 m11 l11">
                <input class="form-control" type="text" name="image" id="image" placeholder="Поиск по картинке">
            </div>
            <div class="col s2 m1 l1 center-align mt-1">
                <button class="waves-effect waves-light btn-floating gradient-45deg-purple-deep-orange" type="submit"><i class="material-icons">search</i></button>
            </div>
        </div>
    </form>



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
