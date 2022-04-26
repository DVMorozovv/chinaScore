{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','home')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/pricing.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/icon.css')}}">

@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/sweetalert/sweetalert.css')}}">

@endsection

{{-- page content --}}
@section('content')

{{--    @dump($tariffs)--}}

    <div class="row">
        <div class="col s12 m12 l12">
            <div id="basic-tabs" class="card card card-default scrollspy">
                <div class="card-content">
{{--                    <h4 class="card-title">Тарифы</h4>--}}
                    <div class="row">
                        <div class="col s12">
                            <div class="row">
                                <div class="col s12">
                                    @include('panels.alert')
                                    <h4 class="header">Тарифы</h4>
                                </div>
                                <div class="plans-container">
                                    @if(isset($user_tariff))
                                        @foreach($tariffs as $tariff)
                                            @if($user_tariff->tariff_id == $tariff->id)
                                                <div class="col s12 m6 l4">
                                                    <div class="card hoverable animate fadeLeft">
                                                        <div class="card-image gradient-45deg-light-blue-cyan waves-effect">
                                                            <div class="card-title">{{$tariff->name}}</div>
                                                            <div class="price">
                                                                <sup><img src="/currency_ruble_white_24dp.svg" alt="ruble" style="width:auto;display: inline-block;"></sup>{{$tariff->price}}
                                                                <sub>/<span>month</span></sub>
                                                            </div>
                                                        </div>
                                                        <div class="card-content">
                                                            <ul class="collection">
                                                                <li class="collection-item">{{$tariff->limit}} excels</li>
                                                                <li class="collection-item">{{$tariff->duration}} days</li>
                                                            </ul>
                                                        </div>
                                                        <div class="card-action center-align">
                                                            <a class="modal-trigger waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow btn"  href="#info">Вы используете</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col s12 m6 l4">
                                                    <div class="card hoverable animate fadeLeft">
                                                        <div class="card-image gradient-45deg-light-blue-cyan waves-effect">
                                                            <div class="card-title">{{$tariff->name}}</div>
                                                            <div class="price">
                                                                <sup><img src="/currency_ruble_white_24dp.svg" alt="ruble" style="width:auto;display: inline-block;"></sup>{{$tariff->price}}
                                                                <sub>/<span>month</span></sub>
                                                            </div>
                                                            {{--                                                <div class="price-desc">Free 1 month</div>--}}
                                                        </div>
                                                        <div class="card-content">
                                                            <ul class="collection">
                                                                <li class="collection-item">{{$tariff->limit}} excels</li>
                                                                <li class="collection-item">{{$tariff->duration}} days</li>
                                                            </ul>
                                                        </div>
                                                        <div class="card-action center-align">
                                                                <a class="modal-trigger waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow btn"  href="#info">Приобрести</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                        @endforeach
                                    @else
                                        @foreach($tariffs as $tariff)
                                            <div class="col s12 m6 l4">
                                                <div class="card hoverable animate fadeLeft">
                                                    <div class="card-image gradient-45deg-light-blue-cyan waves-effect">
                                                        <div class="card-title">{{$tariff->name}}</div>
                                                        <div class="price">
                                                            <sup><img src="/currency_ruble_white_24dp.svg" alt="ruble" style="width:auto;display: inline-block;"></sup>{{$tariff->price}}
                                                            <sub>/<span>month</span></sub>
                                                        </div>
                                                        {{--                                                <div class="price-desc">Free 1 month</div>--}}
                                                    </div>
                                                    <div class="card-content">
                                                        <ul class="collection">
                                                            <li class="collection-item">{{$tariff->limit}} excels</li>
                                                            <li class="collection-item">{{$tariff->duration}} days</li>
                                                        </ul>
                                                    </div>
                                                    <div class="card-action center-align">
                                                        @if(\App\Models\Balance::getBalance(Auth::user()->id) >= $tariff->price)
                                                            <a class="modal-trigger waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow btn"  href="#success">Приобрести</a>
                                                        @else
                                                            <a class="modal-trigger waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow btn"  href="#cancel">Приобрести</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- MODAL SUCCESS -->

                                            <div class="swal-modal modal" id="success" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                <div class="swal-icon swal-icon--success">
                                                    <span class="swal-icon--success__line swal-icon--success__line--long"></span>
                                                    <span class="swal-icon--success__line swal-icon--success__line--tip"></span>

                                                    <div class="swal-icon--success__ring"></div>
                                                    <div class="swal-icon--success__hide-corners"></div>
                                                </div>
                                                <div class="swal-title" style="">Приобрести тариф?</div>
                                                <div class="swal-text" style="">Вы уверены, что хотите приобрести тариф?</div><div class="swal-footer">
                                                    <div class="" style="pointer-events: auto !important">

                                                        <a class="swal-button waves-effect waves-light btn gradient-45deg-purple-deep-orange" href="{{route('buyTariff',  ['tariff_id' => $tariff->id])}}">Приобрести</a>

                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-- MODAL CANCEL -->

<div class="swal-modal modal" id="cancel" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="swal-icon swal-icon--error">
        <div class="swal-icon--error__x-mark">
            <span class="swal-icon--error__line swal-icon--error__line--left"></span>
            <span class="swal-icon--error__line swal-icon--error__line--right"></span>
        </div>
    </div>
    <div class="swal-title" style="">Внимание!</div>
    <div class="swal-text" style="">Не хватает средств на счете!</div><div class="swal-footer">
        <div class="" style="pointer-events: auto !important">
            <a class="swal-button waves-effect waves-light btn gradient-45deg-purple-deep-orange" href="{{route('payment')}}">Пополнить</a>
        </div>
    </div>
</div>

<!-- MODAL INFO -->

<div class="swal-modal modal" id="info" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="swal-icon swal-icon--warning">
    <span class="swal-icon--warning__body">
      <span class="swal-icon--warning__dot"></span>
    </span>
    </div>
    <div class="swal-title" style="">Внимание!</div>
    <div class="swal-text" style="">Вы уже используете тариф!</div><div class="swal-footer">
        <div class="" style="pointer-events: auto !important">
{{--            <a class="swal-button waves-effect waves-light btn gradient-45deg-purple-deep-orange" href="{{route('payment')}}">Пополнить</a>--}}
        </div>
    </div>
</div>



@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/sortable/jquery-sortable-min.js')}}"></script>
    <script src="{{asset('vendors/sweetalert/sweetalert.min.js')}}"></script>

@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/advance-ui-modals.js')}}"></script>
    <script src="{{asset('js/scripts/extra-components-sweetalert.js')}}"></script>

@endsection
