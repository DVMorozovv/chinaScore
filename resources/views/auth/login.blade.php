{{-- layout --}}
@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title','User Login')

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/login.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div id="login-page" class="row">
  <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 login-card bg-opacity-8">
    <form class="login-form" method="POST" action="{{ route('login') }}">
      @csrf
      <div class="row">
        <div class="input-field col s12">
          <h5 class="ml-4">{{ __('Вход') }}</h5>
        </div>
      </div>
{{--      <div class="row margin">--}}
{{--        <div class="input-field col s12">--}}
{{--          <i class="material-icons prefix pt-2">person_outline</i>--}}
{{--          <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email"--}}
{{--            value="{{ old('email') }}"  autocomplete="email" autofocus>--}}
{{--          <label for="email" class="center-align">{{ __('Адрес эл. почты') }}</label>--}}
{{--          @error('email')--}}
{{--          <small class="red-text ml-7" >--}}
{{--            {{ $message }}--}}
{{--          </small>--}}
{{--          @enderror--}}
{{--        </div>--}}
{{--      </div>--}}
      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">person_outline</i>
          <input id="phone" type="text" class=" @error('phone') is-invalid @enderror" name="phone"
            value="{{ old('phone') }}"  autocomplete="phone" autofocus>
          <label for="phone" class="center-align">{{ __('phone') }}</label>
          @error('phone')
          <small class="red-text ml-7" >
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>

      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">lock_outline</i>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password"  autocomplete="current-password">
          <label for="password">{{ __('Пароль') }}</label>
          @error('password')
          <small class="red-text ml-7" >
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>
      <div class="row">
        <div class="col s12 m12 l12 ml-2 mt-1">
          <p>
            <label>
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <span>Запомнить меня</span>
            </label>
          </p>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <button type="submit" class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">
              Войти
          </button>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 m6 l6">
          <p class="margin medium-small"><a href="{{ route('register') }}">Зарегистрироваться</a></p>
        </div>
        <div class="input-field col s6 m6 l6">
          <p class="margin right-align medium-small">
            <a href="{{ route('password.request') }}">Забыли пароль?</a>
          </p>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
    <script src="{{asset('vendors/formatter/jquery.formatter.min.js')}}"></script>
@endsection


{{-- page script --}}
@section('page-script')
    <script src="{{asset('js/scripts/page-contact.js')}}"></script>
    <script src="{{asset('js/scripts/form-masks.js')}}"></script>
    <script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
    <script src="{{asset('js/scripts/form-elements.js')}}"></script>
@endsection
