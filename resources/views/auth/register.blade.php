{{-- layout --}}
@extends('layouts.fullLayoutMaster')

{{-- page title --}}
@section('title','User Register')

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/register.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div id="register-page" class="row">
  <div class="col s12 m6 l4 z-depth-4 card-panel border-radius-6 register-card bg-opacity-8">
    <form class="login-form" method="POST" action="{{ route('register') }}">
      @csrf
      <div class="row">
        <div class="input-field col s12">
          <h5 class="ml-4">Регистрация</h5>
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">person_outline</i>
          <input id="name" type="text" class="@error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"
             autocomplete="name" autofocus>
          <label for="name" class="center-align">Имя</label>
          @error('name')
          <small class="red-text ml-7" role="alert">
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">mail_outline</i>
          <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}"  autocomplete="email">
          <label for="email">Email</label>
          @error('email')
          <small class="red-text ml-7" role="alert">
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">lock_outline</i>
          <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password"
            autocomplete="new-password">
          <label for="password">Пароль</label>
          @error('password')
          <small class="red-text ml-7" role="alert">
            {{ $message }}
          </small>
          @enderror
        </div>
      </div>
      <div class="row margin">
        <div class="input-field col s12">
          <i class="material-icons prefix pt-2">lock_outline</i>
          <input id="password-confirm" type="password" name="password_confirmation"
            autocomplete="new-password">
          <label for="password-confirm">Повторите пароль</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <button type="submit"
            class="btn waves-effect waves-light border-round gradient-45deg-purple-deep-orange col s12">Зарегистрироваться</button>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <p class="margin medium-small"><a href="{{ route('login')}}">Уже есть профиль? Войти</a></p>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
