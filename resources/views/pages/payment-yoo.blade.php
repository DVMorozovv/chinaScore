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
@endsection

{{-- page content --}}
@section('content')


    <div class="mt-2 title_bg mb-2">
        <div class="container ">
            <h3 class="home_title">Баланс: {{$balance}} </h3>
        </div>
    </div>

    <form method="post" action="{{ route('payment.create') }}">
        @csrf
        <div class="row">
            <div class="input-field col s12 m12 l10">
                <input id="amount" name="amount" type="number">
                <label for="amount">Сумма платежа</label>
            </div>

            <input hidden id="description" name="description" value="{{\App\Enums\PaymentTypeEnum::REPLENISHMENT}}">
            <input hidden id="user_id" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()}}">

            <div class="input-field col s12 m12 l2">
                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Пополнить
                    <i class="material-icons right">send</i>
                </button>
            </div>
        </div>
    </form>


    <div class="row">
        <div class="col s12 m12 l12">
            <div id="striped-table" class="card card card-default scrollspy">
                <div class="card-content">
                    <h4 class="card-title">История операций</h4>

                    <div class="row">
                        <div class="col s12">
                            <table class="striped">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Сумма</th>
                                    <th>Описание</th>
                                    <th>Статус</th>
                                    <th>Дата и время</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse($transactions as $transaction)
                                        <tr>
                                            @if ($loop->first)
                                                <td>{{$counter=1}}</td>
                                            @else
                                                <td>{{++$counter}}</td>
                                            @endif
                                            <td @if($transaction->description === 'REPLENISHMENT' or $transaction->description === 'REFERRAL INCOME') style="color: green" @else style="color: red" @endif>{{ $transaction->amount }}</td>
                                            <td>{{$transaction->description}}</td>
                                            <td>{{ $transaction->status }}</td>
                                            <td>{{ $transaction->updated_at }}</td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="5">Транзакций нет</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- vendor scripts --}}
@section('vendor-script')
@endsection

{{-- page scripts --}}
@section('page-script')
@endsection
