@extends('layouts.fullLayoutMaster')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-content">
        <div class="card-title">{{ __('Подтвердтите Свой Адрес Электронной Почты') }}</div>
          @if (session('resent'))
          <div class="card-alert card green lighten-5" role="alert">
              <div class="card-content green-text">
                {{ __('Ссылка для подтверждения была отправлена на адрес вашей электронной почты.') }}
              </div>
          </div>
          @endif

          {{ __('Прежде чем продолжить, проверьте свою электронную почту на наличие ссылки для подтверждения.') }}

          <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
              @csrf
              <button type="submit"
                  class="waves-effect waves-light btn">{{ __('нажмите, чтобы отправить повторно') }}</button>.
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
