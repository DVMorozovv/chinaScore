{{-- layout extend --}}
@extends('layouts.adminLayoutMaster')

{{-- page title --}}
@section('title','Main')

{{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css"
          href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/select.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/data-tables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-contacts.css')}}">
@endsection

{{-- page content --}}
@section('content')

    <div class="section section-data-tables">
    @include('panels.alert')
    <!-- DataTables example -->
        <div class="row">
            <div class="col s12 m12 l12">
                <div id="button-trigger" class="card card card-default scrollspy">
                    <div class="card-content">
                        <h4 class="card-title">DataTables example</h4>
                        <div class="row">
                            <div class="col s12">
                                <p>DataTables has most features enabled by default, so all you need to do to use it with your own tables
                                    is to call the construction function.</p>
                            </div>
                            <div class="col s12">
                                <table id="data-table-simple" class="display">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Message</th>
                                        <th>Created at</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($supports as $support)
                                        <tr>
                                            <td>{{ $support->id }}</td>
                                            <td>{{ $support->name }}</td>
                                            <td>{{ $support->email }}</td>
                                            <td>{{ $support->phone }}</td>
                                            <td>{{ $support->message }}</td>
                                            <td>{{ $support->created_at }}</td>
                                            <td>
                                                <div class="invoice-action display-flex">
{{--                                                    <a href="{{ route('support.edit', $support['id']) }}" class="invoice-action-view mr-4">--}}
{{--                                                        <i class="material-icons">edit</i>--}}
{{--                                                    </a>--}}
                                                    <form action="{{ route('support.destroy', $support['id']) }}" method="post" name="form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" style="
    color: #3949ab;
    text-decoration: none;
    border: none;
    background: transparent;
    -webkit-tap-highlight-color: transparent;
">
                                                            <i class="material-icons">delete</i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- vendor scripts --}}
@section('vendor-script')
    <script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('vendors/data-tables/js/dataTables.select.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
    <script src="{{asset('js/scripts/data-tables.js')}}"></script>

@endsection
