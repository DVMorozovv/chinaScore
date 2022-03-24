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
                        <form method="POST" action="{{ route('tariffs.update', $tariff['id']) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="name" type="text" name="name" value="{{$tariff->name}}">
                                    <label for="name">Name</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="description" name="description" class="materialize-textarea">{{$tariff->description}}</textarea>
                                    <label for="description">Description</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="price" type="text" name="price" value="{{$tariff->price}}">
                                    <label for="price">Price</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="limit" type="text" name="limit" value="{{$tariff->limit}}">
                                    <label for="limit">Limit</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="duration" type="text" name="duration" value="{{$tariff->duration}}">
                                    <label for="duration">Duration</label>
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

{{-- vendor scripts --}}
@section('vendor-script')

@endsection

{{-- page scripts --}}
@section('page-script')
@endsection
