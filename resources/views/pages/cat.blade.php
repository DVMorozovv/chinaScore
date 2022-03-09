{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','categories')

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

<div class="mt-2 title_bg mb-2">
    <div class="container "><h3 class=" home_title">Категории</h3></div>
</div>

<div class="container">
    @if(isset($id))
        <div class="mb-2">
            <h4>Искать по всем категориям</h4>
            <form action="{{ route('search_form', $id) }}" method="POST">
                @csrf
                <div class="row ">
                    <div class="col s10 m11 l11"><input class="form-control" type="text" name="title" id="title" placeholder="Поиск по названию" required minlength="1" ></div>
                    <div class="col s2 m1 l1 center-align mt-1">
                        <button class="waves-effect waves-light btn-floating gradient-45deg-purple-deep-orange" type="submit"><i class="material-icons">search</i></button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    @if(empty($categories))
        <h4>Подкатегорий нет</h4>
        <a class="waves-effect waves-light btn gradient-45deg-purple-deep-orange" href="#">Скачать информацию по всем товарам данной категории</a>
    @endif

    @for($i = 0; $i < count($categories); $i++)
        @if ( $categories[$i]['IsVirtual'] == true)
        <div class="cat">
            <h4><a class="btn btn-secondary btn-sm" href="{{ route ('categories_child', $categories[$i]['Id']) }}">{{ $categories[$i]['Name'] }}</a></h4>
        </div>
        @else
        <div class="row  mb-1">
            <div class="col s10 m11 l11"><a class="categorie_name a_color" href="{{ route ('categories_child', $categories[$i]['Id']) }}">{{ $categories[$i]['Name'] }}</a></div>
            <div class="col s2 m1 l1 center-align">
                <a  href="{{ route ('get_item_by_cat', [ $categories[$i]['Id'], 'cat_name' => $categories[$i]['Name']] ) }}" class="waves-effect waves-light btn-floating gradient-45deg-purple-deep-orange"><i class="material-icons">file_download</i></a>
            </div>
        </div>
        @endif
    @endfor
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
