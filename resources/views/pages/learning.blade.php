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

        <div class="container "><h1 class="mt-5 home_title">Обучение</h1></div>

{{--        <div id="horizontal-card" class="section">--}}
{{--            <h4 class="header">Horizontal Card</h4>--}}
{{--            <p>Here is the standard card with a horizontal image.</p>--}}
{{--            <div class="row">--}}
{{--                @foreach($articles as $article)--}}
{{--                <div class="col s12 m6 l6">--}}
{{--                    <div class="card horizontal ">--}}
{{--                        <div class="card-image"><img  style="" src="storage/images/articles/{{$article->image}}" alt="" /></div>--}}
{{--                        <div class="card-stacked">--}}
{{--                            <div class="card-content">--}}
{{--                                <p>I am a very simple card with link. I am good at containing small bits of--}}
{{--                                    information.</p>--}}
{{--                            </div>--}}
{{--                            <div class="card-action"><a href="#">Подробнее</a></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @endforeach--}}
{{--            </div>--}}
{{--        </div>--}}

        <div id="card-reveal" class="section">
            <h4 class="header">Card Reveal</h4>
            <p>Here you can add a card that reveals more information once clicked.</p>

            <div class="row">
                @foreach($articles as $article)
                <div class="col s12 m6 l4">
                    <div class="card">
                        <div class="card-image waves-effect waves-block waves-light" style="height: 250px">
                            <img class="activator" src="storage/images/articles/{{$article->image}}" alt="image" />
                        </div>
                        <div class="card-content"><span class="card-title activator grey-text text-darken-4">{{$article->heading}} <i class="material-icons right">more_vert</i></span>
                            <p><a href="{{route('article', $article->id)}}">Подробнее</a></p>
                        </div>
                        <div class="card-reveal"><span class="card-title grey-text text-darken-4">{{$article->heading}} <i class="material-icons right">close</i></span>
                            <p>Here is some more information about this product that is only revealed once clicked on.</p>
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
