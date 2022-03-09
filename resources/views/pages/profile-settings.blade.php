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
                                        <input type="text" id="name" name="name" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <label for="email">E-mail</label>
                                        <input id="email" type="email" name="email" value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end form-action">
                                    <button type="submit" class="btn indigo waves-effect waves-light mr-2">
                                        Save changes
                                    </button>
                                    <button type="button" class="btn btn-light-pink waves-effect waves-light mb-1">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div id="change-password">
                    <div class="card-panel">
                        <form class="paaswordvalidate">
                            <div class="row">
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="oldpswd" name="oldpswd" type="password" data-error=".errorTxt4">
                                        <label for="oldpswd">Old Password</label>
                                        <small class="errorTxt4"></small>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="newpswd" name="newpswd" type="password" data-error=".errorTxt5">
                                        <label for="newpswd">New Password</label>
                                        <small class="errorTxt5"></small>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <div class="input-field">
                                        <input id="repswd" type="password" name="repswd" data-error=".errorTxt6">
                                        <label for="repswd">Retype new Password</label>
                                        <small class="errorTxt6"></small>
                                    </div>
                                </div>
                                <div class="col s12 display-flex justify-content-end form-action">
                                    <button type="submit" class="btn indigo waves-effect waves-light mr-1">Save changes</button>
                                    <button type="reset" class="btn btn-light-pink waves-effect waves-light">Cancel</button>
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
