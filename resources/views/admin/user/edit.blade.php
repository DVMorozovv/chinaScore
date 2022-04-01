{{-- layout extend --}}
@extends('layouts.adminLayoutMaster')

{{-- page title --}}
@section('title','Main')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
@endsection

{{-- page content --}}
@section('content')
    <div class="seaction">
        @include('panels.alert')
        <div class="row">
            <div class="col s12 m12 l12">
                <div id="Form-advance" class="card card card-default scrollspy">
                    <div class="card-content">
                        <h4 class="card-title">Form Advance</h4>
                        <form method="POST" action="{{ route('user.update', $user['id']) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="name" type="text" name="name" value="{{$user->name}}">
                                    <label for="name">Name</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="email" type="text" name="email" value="{{$user->email}}">
                                    <label for="email">Email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="phone" type="text" name="phone" value="{{$user->phone}}">
                                    <label for="phone">Phone</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="password" type="text" name="password">
                                    <label for="password">New password</label>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Submit
                                            <i class="material-icons right">send</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
