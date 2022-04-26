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

<div class="mt-2 title_bg mb-2">
        <div class="container "><h3 class="home_title">Поиск</h3></div>
</div>

<div class="container">
    <div>
        @include('panels.alert')
        @error('message')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

    @if(isset($cat_name))
        <h4>Искать по категории: {{ $cat_name }}</h4>
        @else
        <h4>Искать по всем категориям</h4>
        @endif

        <form action="{{ route('search_cat_form', $id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col s10 m11 l11">
                    <input class="form-control" type="text" name="title" id="title" required minlength="1" placeholder="Поиск по названию" >
                </div>
                <input type="hidden" name="cat_name"  value="{{ $cat_name }}"/>
                <div class="col s2 m1 l1 center-align mt-1">
                    <button class="waves-effect waves-light btn-floating gradient-45deg-purple-deep-orange" type="submit"><i class="material-icons">search</i></button>
                </div>
            </div>
        </form>

        @if(isset($title))
            <div class="search_title" ><h5>Поиск: {{ $title }}</h5></div>
        @endif

    </div>


    @for($i = 0; $i < count($items); $i++)
        @if ( $total_count == 0)
        <div>
            <h4>Товаров в категории нет</h4>
        </div>
        @else
        <div class="row">
            <div class="col-12"><p>{{ $i }}. {{ $items[$i]['Title'] }};</p></div>
        </div>
        @endif
    @endfor

    <div class="row valign-wrapper mb-2">
        <div class="col s12 m8 l6"><h6>Найдено товаров: {{ $total_count }}</h6></div>
        <!-- <div class="col-3"><h4>id:{{-- {{ $id }} --}}</h4></div> -->
        <div class="col s12 m4 l6 center">
            <a class="waves-effect waves-light btn modal-trigger btn_min_width gradient-45deg-purple-deep-orange"  href="#modal1"><i class="material-icons right">file_download</i>Скачать</a>
        </div>
    </div>

</div>


<!-- Modal Structure -->
@if(!isset($result))
    <div class="modal" id="modal1" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <h4 class="modal-title" id="exampleModalToggleLabel">Выберете способ сортировки товаров</h4>
                <div class="card-alert card gradient-45deg-red-pink">
                    <div class="card-content white-text">
                        <p>
                            <i class="material-icons">info_outline</i>  Вы не приобрели тариф, пополните баланс чтобы продолжить!</p>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="@if(\App\Models\Balance::getBalance(Auth::user()->id) >= 200) @if(isset($title)){{ route('create', [ $id, 'title' => $title]) }}@else{{ route('create', $id) }}@endif @else {{route('payment')}} @endif" method="get">
                        @csrf
                        <div class="">
                            <div class="input-field col s12">
                                <select name="filter" class="" aria-label="Default select example">
                                    <option value="0" selected>По умолчанию</option>
                                    <option value="1">Объем продаж по убыванию</option>
                                    <option value="2">Цена по убыванию</option>
                                    <option value="3">Цена по возрастанию</option>
                                    <option value="4">Рейтинг продавца по убыванию</option>
                                </select>
                                <label>Сортировать</label>
                            </div>
                            @if(isset($title))
                                <input type="hidden" name="title"  value="{{ $title }}">
                            @endif
                            <input type="hidden" name="id" value="{{$id}}" id="id">
                            <input type="hidden" name="isBuy" value="{{true}}">
                            <div class="">
                                <button class="btn  btn-primary form_btn gradient-45deg-purple-deep-orange" type="submit">@if(\App\Models\Balance::getBalance(Auth::user()->id) >= 200) Скачать @else Пополнить @endif</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@elseif($result == false)
<div class="modal" id="modal1" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <h4 class="modal-title" id="exampleModalToggleLabel">Выберете способ сортировки товаров</h4>
        <div class="card-alert card gradient-45deg-red-pink">
            <div class="card-content white-text">
                <p>
                    <i class="material-icons">info_outline</i>  У Вас закончился лимит скачиваний, пополнить баланс?</p>
            </div>
        </div>
      <div class="modal-body">
        <form action="@if(\App\Models\Balance::getBalance(Auth::user()->id) >= 200) @if(isset($title)){{ route('create', [ $id, 'title' => $title]) }}@else{{ route('create', $id) }}@endif @else {{route('payment')}} @endif" method="GET">
        @csrf
            <div class="">
                <div class="input-field col s12">
                    <select name="filter" class="" aria-label="Default select example">
                        <option value="0" selected>По умолчанию</option>
                        <option value="1">Объем продаж по убыванию</option>
                        <option value="2">Цена по убыванию</option>
                        <option value="3">Цена по возрастанию</option>
                        <option value="4">Рейтинг продавца по убыванию</option>
                    </select>
                    <label>Сортировать</label>
                </div>
                @if(isset($title))
                    <input type="hidden" name="title"  value="{{ $title }}" >
                @endif
                <input type="hidden" name="id" value="{{$id}}" id="id">
                <input type="hidden" name="isBuy" value="{{true}}">
                <div class="">
                    <button class="btn  btn-primary form_btn gradient-45deg-purple-deep-orange" type="submit">@if(\App\Models\Balance::getBalance(Auth::user()->id) >= 200) Скачать @else Пополнить @endif</button>
                </div>
            </div>
        </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
@else
    <div class="modal" id="modal1" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <h4 class="modal-title" id="exampleModalToggleLabel">Выберете способ сортировки товаров</h4>
                <div class="modal-body">
                    <form action="@if(isset($title)){{ route('create', [ $id, 'title' => $title]) }}@else{{ route('create', $id) }}@endif" method="GET">
                        @csrf
                        <div class="">
                            <div class="input-field col s12">
                                <select name="filter" class="" aria-label="Default select example">
                                    <option value="0" selected>По умолчанию</option>
                                    <option value="1">Объем продаж по убыванию</option>
                                    <option value="2">Цена по убыванию</option>
                                    <option value="3">Цена по возрастанию</option>
                                    <option value="4">Рейтинг продавца по убыванию</option>
                                </select>
                                <label>Сортировать</label>
                            </div>
                            @if(isset($title))
                                <input type="hidden" name="title"  value="{{ $title }}" />
                            @endif
                            <div class="">
                                <button class="btn  btn-primary form_btn gradient-45deg-purple-deep-orange" type="submit">Скачать</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
@endif


@endsection

{{-- vendor scripts --}}
@section('vendor-script')
<script src="{{asset('vendors/sortable/jquery-sortable-min.js')}}"></script>
<script src="{{asset('vendors/quill/quill.min.js')}}"></script>

@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>

@endsection
