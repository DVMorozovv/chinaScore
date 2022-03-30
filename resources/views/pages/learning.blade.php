{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','home')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/animate-css/animate.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/cards-basic.css')}}">
@endsection

{{-- page content --}}
@section('content')

{{--        <div class="container "><h2 class="header">Обучение</h2></div>--}}

        <div id="card-reveal" class="section">
            <h4 class="header mt-5">Обучение</h4>
            <p>Here you can add a card that reveals more information once clicked.</p>

            <div class="row">
                @foreach($articles as $article)
                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light" style="height: 250px">
                            <img class="activator" src="storage/images/articles/{{$article->image}}" alt="image" />
                        </div>
                        <div class="card-content">
                            <div class="row">
                                <div class="col s10 m10 l10"><span class="card-title activator grey-text text-darken-4 truncate">{{$article->heading}}</span></div>
                                <div class="col s2 m2 l2"><i class="material-icons right">more_vert</i></div>
                            </div>
                            <p><a href="{{route('article', $article->id)}}">Подробнее</a></p>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4"><i class="material-icons right">close</i></span>
                            <span class="card-title grey-text text-darken-4">{{$article->heading}}</span>
                            <p>{{$article->description}}</p>
                        </div>
                    </div>
                </div>
                @endforeach
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
