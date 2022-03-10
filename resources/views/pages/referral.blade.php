{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','home')

{{-- vendor styles --}}
@section('vendor-style')
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

{{--    <ul class="list-group mt-3">--}}
{{--        <li class="list-group-item">Username: {{ Auth::user()->name }}</li>--}}
{{--        <li class="list-group-item">Email: {{ Auth::user()->email }}</li>--}}
{{--        <li class="list-group-item">Referral link: {{ Auth::user()->referral_link }}</li>--}}
{{--        <li class="list-group-item">Referrer: {{ Auth::user()->referrer->name ?? 'Not Specified' }}</li>--}}
{{--        <li class="list-group-item">Refferal count: {{ count(Auth::user()->referrals)  ?? '0' }}</li>--}}
{{--    </ul>--}}


    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card card card-default">
                <div class="card-content">
                    <h4 class="card-title">Как использовать реферальную систему?</h4>
                    <p>Скопируйте вашу партнерскую ссылку и получайте 10% от покупок каждого пользователя, который зарегистрировался на нашей платформе и приобрел тариф!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card card card-default">
                <div class="card-content">
                    <h4 class="card-title">Ваша партнерская ссылка</h4>
                    <p>Скопируйте вашу ссылку и пришлите ее вашему партнеру, после регистрации, он отобразится в списке ваших партнеров.</p>
                    <div class="row">
                        <div class="input-field col m4 s12">
                            <input type="text" value="{{ Auth::user()->referral_link }}" type="text" id="myInput" readonly>
                        </div>
                        <div class="input-field col m4 s12">
                            <div class="input-field col s12">
                                <button class="waves-effect waves-light btn gradient-45deg-purple-deep-orange" onclick="myFunction()">Скопировать</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if($referralsFirst != [])
    <div class="row">
        <div class="col s12 m12 l12">
            <div id="striped-table" class="card card card-default scrollspy">
                <div class="card-content">
                    <h4 class="card-title">Рефералы</h4>

                    <div class="row">
                        <div class="col s12">
                        </div>
                        <div class="col s12">
                            <table class="striped">
                                <thead>
                                <tr>
                                    <th data-field="id">Name</th>
                                    <th data-field="name">Email</th>
                                    <th data-field="price">Profit</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($referralsFirst as $referralFirst)
                                    <tr>
                                        <td>{{$referralFirst["name"]}}</td>
                                        <td>{{$referralFirst["email"]}}</td>
                                        <td>$0.00</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif



    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            document.execCommand("copy");
        }
    </script>



@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/sortable/jquery-sortable-min.js')}}"></script>
    <script src="{{asset('vendors/quill/quill.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')

@endsection
