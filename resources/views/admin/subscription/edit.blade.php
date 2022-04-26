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
                        <form method="POST" action="{{ route('userTariff.update', $userTariff['id']) }}">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="input-field col s12">
{{--                                    <input id="status" type="text" name="status" value="{{$userTariff->status}}">--}}
                                    <label for="limit">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="1" @if($userTariff['status'] === 1)selected @endif>Активная</option>
                                        <option value="0" @if($userTariff['status'] === 0)selected @endif>Не активная</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="days_end_sub" type="text" name="days_end_sub" value="{{$userTariff->days_end_sub}}">
                                    <label for="days_end_sub">Duration</label>
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
