{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Blog List Page')

{{-- page style --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-file-manager.css')}}">
@endsection

{{-- page content --}}
@section('content')

    <div class="section app-file-manager-wrapper">
        <div class="app-file-overlay"></div>
        <div class="content-right">
            <div class="app-file-area">
                <div class="app-file-content">
                    <h6 class="font-weight-700 mb-3">Файлы</h6>

{{--                    <span class="app-file-label">Folder</span>--}}
                    <div class="row app-file-folder mb-3">
                        @foreach($folders as $folder)
                        <div class="col xl3 l6 m4 s6">
                            <div class="card box-shadow-none mb-1 ">
                                <a href="{{ route('user-files', ['folder_id' => $folder->id]) }}" class="a_file_icon_download">
                                    <div class="card-content">
                                    <div class="app-file-folder-content  display-flex align-items-center">
                                        <div class="app-file-folder-logo mr-3">
                                            <i class="material-icons">folder_open</i>
                                        </div>
                                        <div class="app-file-folder-details">
                                            <div class="app-file-folder-name font-weight-700">Search by {{$folder->method}}</div>
                                            <div class="app-file-folder-size mt-2">Количество файлов: {{$folder->count}}</div>
                                            <div class="app-file-folder-size">{{$folder->created_at}}</div>

                                        </div>
                                    </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/app-file-manager.js')}}"></script>
@endsection
