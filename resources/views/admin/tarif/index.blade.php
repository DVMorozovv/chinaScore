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
    <link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
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
                                <table id="scroll-vert-hor" class="display">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description-1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th>Price</th>
                                        <th>Limit</th>
                                        <th>Items limit</th>
                                        <th>Is active</th>
                                        <th>Duration</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tariffs as $tariff)
                                    <tr>
                                        <td>{{ $tariff->id }}</td>
                                        <td>{{ $tariff->name }}</td>
                                        <td style="white-space: pre-line">{{ $tariff->description }}</td>
                                        <td style="white-space: pre-line">{{ $tariff->description_2 }}</td>
                                        <td style="white-space: pre-line">{{ $tariff->description_3 }}</td>
                                        <td style="white-space: pre-line">{{ $tariff->description_4 }}</td>
                                        <td style="white-space: pre-line">{{ $tariff->description_5 }}</td>
                                        <td style="white-space: pre-line">{{ $tariff->description_6 }}</td>
                                        <td>{{ $tariff->price }}</td>
                                        <td>{{ $tariff->limit }}</td>
                                        <td>{{ $tariff->items_limit }}</td>
                                        <td>{{ $tariff->is_active }}</td>
                                        <td>{{ $tariff->duration }}</td>
                                        <td>
                                            <div class="invoice-action display-flex">
                                                <a href="{{ route('tariffs.edit', $tariff['id']) }}" class="invoice-action-view mr-4">
                                                    <i class="material-icons">edit</i>
                                                </a>
                                                    <form action="{{ route('tariffs.destroy', $tariff['id']) }}" method="post" name="form">
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
