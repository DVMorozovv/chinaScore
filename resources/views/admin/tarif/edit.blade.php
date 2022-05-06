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
                                    <textarea id="description_2" name="description_2" class="materialize-textarea"></textarea>
                                    <label for="description_2">Description-2</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="description_3" name="description_3" class="materialize-textarea"></textarea>
                                    <label for="description_3">Description-3</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="description_4" name="description_4" class="materialize-textarea"></textarea>
                                    <label for="description_4">Description-4</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="description_5" name="description_5" class="materialize-textarea"></textarea>
                                    <label for="description_5">Description-5</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="description_6" name="description_6" class="materialize-textarea"></textarea>
                                    <label for="description_6">Description-6</label>
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
                                    <input id="items_limit" type="text" name="items_limit" value="{{$tariff->items_limit}}">
                                    <label for="items_limit">Limit</label>
                                </div>
                            </div>
                            <div class="input-field col s12">
                                <label for="is_active">Is active</label>
                                <select class="form-control" name="is_active" id="is_active">
                                    <option value="1" @if($tariff['is_active'] === 1)selected @endif>Активная</option>
                                    <option value="0" @if($tariff['is_active'] === 0)selected @endif>Не активная</option>
                                </select>
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
