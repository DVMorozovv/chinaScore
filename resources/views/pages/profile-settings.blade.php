{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Account Settings')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
@endsection

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-account-settings.css')}}">
@endsection

{{-- page content --}}
@section('content')

    <!-- Account settings -->
    <section class="tabs-vertical mt-1 section">
        <div class="row">
            <div class="col l4 s12">
                <!-- tabs  -->
                <div class="card-panel">
                    <ul class="tabs">
                        <li class="tab">
                            <a href="#general">
                                <i class="material-icons">brightness_low</i>
                                <span>General</span>
                            </a>
                        </li>
                        <li class="tab">
                            <a href="#change-password">
                                <i class="material-icons">lock_open</i>
                                <span>Change Password</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col l8 s12">

            @include('panels.alert')

                <div id="general">
                    <div class="card-panel">
                        <form class="" method="POST" action="{{ route('RedactProfileForm') }}">
                            @csrf
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field">
                                        <label for="uname">Username</label>
                                        <input type="text" id="name" name="name" readonly value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <label for="email">E-mail</label>
                                        <input id="email" type="email" name="email" readonly value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
{{--                                <div class="col s12 display-flex justify-content-end form-action">--}}
{{--                                    <button type="submit" class="btn indigo waves-effect waves-light mr-2">--}}
{{--                                        Save changes--}}
{{--                                    </button>--}}
{{--                                    <button type="button" class="btn btn-light-pink waves-effect waves-light mb-1">Cancel</button>--}}
{{--                                </div>--}}
                            </div>
                        </form>
                    </div>
                </div>

                <div id="change-password">
                    <div class="card-panel">
                        <form class="" method="POST" action="{{ route('updateUserPassword') }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="old_password" name="old_password" type="password">
                                        <label for="old_password">Old Password</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="password" name="password" type="password">
                                        <label for="password">New Password</label>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="password" type="password" name="password_confirmation">
                                        <label for="password">Retype new Password</label>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end form-action">
                                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Save changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

{{-- page scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
    <script src="{{asset('js/scripts/page-account-settings.js')}}"></script>
@endsection
