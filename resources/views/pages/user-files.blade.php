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

                <span class="app-file-label">Последние добавленные файлы</span>
                <div class="row app-file-recent-access mb-3">
                    @foreach($recently_files as $file)
                        <div class="col xl3 l6 m3 s12">
                            <div class="card box-shadow-none mb-1 {{--app-file-info--}}">
                                <div class="card-content">
                                    <div class="app-file-content-logo grey lighten-4">
                                        <a href="{{route('download_file', ['file_id'=>$file->id])}}" class="a_file_icon_download">
                                            <div class="fonticon">
                                                <i class="material-icons">file_download</i>
                                            </div>
                                        </a>
                                        <img class="recent-file" src="{{asset('images/icon/xls-image.png')}}" height="38" width="30" alt="Card image cap">
                                    </div>
                                    <div class="app-file-recent-details">
                                        <div class="app-file-name font-weight-700">{{$file->name}}</div>
                                        <div class="app-file-last-access">{{$file->created_at}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <span class="app-file-label">Все файлы</span>
                <div class="row app-file-recent-access mb-3">
                    @foreach($files as $file)
                        <div class="col xl3 l6 m3 s12">
                            <div class="card box-shadow-none mb-1 {{--app-file-info--}}">
                                <div class="card-content">
                                    <div class="app-file-content-logo grey lighten-4">
                                        <a href="{{route('download_file', ['file_id'=>$file->id])}}" class="a_file_icon_download">
                                            <div class="fonticon">
                                                <i class="material-icons">file_download</i>
                                            </div>
                                        </a>
                                        <img class="recent-file" src="{{asset('images/icon/xls-image.png')}}" height="38" width="30" alt="Card image cap">
                                    </div>
                                    <div class="app-file-recent-details">
                                        <div class="app-file-name font-weight-700">{{$file->name}}</div>
                                        <div class="app-file-last-access">{{$file->created_at}}</div>
                                    </div>
                                </div>
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
