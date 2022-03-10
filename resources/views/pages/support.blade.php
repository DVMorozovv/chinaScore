{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Page Support')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/fontawesome/css/all.min.css')}}">
@endsection

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-contact.css')}}">
@endsection

{{-- page content --}}
@section('content')
    <!-- Support Us -->
    <div id="contact-us" class="section">
        <div class="app-wrapper">
            <div class="contact-header">
                <div class="row contact-us ml-0 mr-0">
                    <div class="col s12 m12 l4 {{--sidebar-title--}}">
                        <h5 class="m-0"><i class="material-icons contact-icon vertical-text-top">mail_outline</i> Contact Us</h5>
                        <p class="m-0 font-weight-500 mt-6 hide-on-med-and-down text-ellipsis">Looking for design partner?</p>
                        <span class="social-icons hide-on-med-and-down">
{{--                            <i class="fab fa-behance"></i>--}}
{{--                            <i class="fab fa-dribbble ml-5"></i>--}}
{{--                            <i class="fab fa-facebook-f ml-5"></i>--}}
{{--                            <i class="fab fa-instagram ml-5"></i>--}}
                        </span>
                    </div>
                    <div class="col s12 m12 l8 form-header">
                        <h6 class="form-header-text"><i class="material-icons"> mail_outline </i> Write us a few words about your
                            project.</h6>
                    </div>
                </div>
            </div>

            <!-- Support Sidenav -->
            <div id="sidebar-list" class="row contact-sidenav ml-0 mr-0">
                <div class="col s12 m12 l4">
                    <!-- Sidebar Area Starts -->
                    <div class="sidebar-left sidebar-fixed">
                        <div class="sidebar">
                            <div class="sidebar-content">
                                <div class="sidebar-menu list-group position-relative">
                                    <div class="sidebar-list-padding app-sidebar contact-app-sidebar" id="contact-sidenav">
                                        <ul class="contact-list display-grid">
                                            <li>
                                                <h5 class="m-0">What will be next step?</h5>
                                            </li>
                                            <li>
                                                <h6 class="mt-5 line-height">You are one step closer to build your perfect product</h6>
                                            </li>
                                            <li>
                                                <hr class="mt-5">
                                            </li>
                                        </ul>
                                        <div class="row">
                                            <!-- Place -->
                                            <div class="col s12 place mt-4 p-0">
                                                <div class="col s2 m2 l2"><i class="material-icons"> place </i></div>
                                                <div class="col s10 m10 l10">
                                                    <p class="m-0">360 King street, <br> Feasterville Trevose, PA 19053</p>
                                                </div>
                                            </div>
                                            <!-- Phone -->
                                            <div class="col s12 phone mt-4 p-0">
                                                <div class="col s2 m2 l2"><i class="material-icons"> call </i></div>
                                                <div class="col s10 m10 l10">
                                                    <p class="m-0">(800) 900-200-333</p>
                                                </div>
                                            </div>
                                            <!-- Mail -->
                                            <div class="col s12 mail mt-4 p-0">
                                                <div class="col s2 m2 l2"><i class="material-icons"> mail_outline </i></div>
                                                <div class="col s10 m10 l10">
                                                    <p class="m-0">info@domain.com</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <a href="#" data-target="contact-sidenav" class="sidenav-trigger"><i class="material-icons">menu</i></a>

                            </div>
                        </div>
                    </div>
                    <!-- Sidebar Area Ends -->
                </div>
                <div class="col s12 m12 l8 contact-form margin-top-contact">
                    <div class="row">
                        @include('panels.alert')
                        <form class="col s12" action="{{ route('contactForm') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="input-field col m6 s12">
                                    <input id="name" name="name" type="text" class="" value="@if(auth()->user()){{ Auth::user()->name }} @endif">
                                    <label for="name">Your Name</label>
                                </div>
                                <div class="input-field col m6 s12">
                                    <input id="email" name="email" type="text" class="" value="@if(auth()->user()){{ Auth::user()->email }} @endif">
                                    <label for="email">Your e-mail</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col m12 s12">
                                    <input id="phone-demo" name="phone-demo" type="text" class=""  value="{{ old('phone-demo') }}">
                                    <label for="phone-demo">Phone</label>
                                </div>
                                <div class="input-field col s12 width-100">
                                    <textarea id="message" name="message"  class="materialize-textarea"></textarea>
                                    <label for="message">Your message</label>
                                    <button class="waves-effect waves-light btn" type="submit">Send</button>
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
