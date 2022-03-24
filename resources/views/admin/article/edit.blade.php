{{-- layout extend --}}
@extends('layouts.adminLayoutMaster')

{{-- page title --}}
@section('title','Main')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/dropify/css/dropify.min.css')}}">
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
                        <form method="POST" action="{{ route('articles.update', $article['id']) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="heading" type="text" name="heading" value="{{$article->heading}}">
                                    <label for="heading">Heading</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="content" name="text" class="materialize-textarea">{{$article->content}}</textarea>
                                    <label for="content">Content</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="link" type="text" name="link" value="{{$article->link}}">
                                    <label for="link">Link</label>
                                </div>
                            </div>
                            <div class="row">
                                <div id="file-upload" class="section">
                                    <div class="row section">
                                        <div class="col s12 m12 l12">
                                            <p>Image</p>
                                        </div>
                                        <div class="col s12 m12 l12">
                                            <input type="file" id="input-file-now" class="dropify" name="image" data-default-file=""/>
                                        </div>
                                    </div>
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
    <script src="{{asset('vendors/dropify/js/dropify.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/form-file-uploads.js')}}"></script>
@endsection
