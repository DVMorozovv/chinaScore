@isset($pageConfigs)
{!! Helper::updatePageConfig($pageConfigs) !!}
@endisset

    <!DOCTYPE html>
@php
      $configData = Helper::applClasses();
@endphp

<html class="loading"
      lang="@if(session()->has('locale')){{session()->get('locale')}}@else{{$configData['defaultLanguage']}}@endif"
      data-textdirection="{{ env('MIX_CONTENT_DIRECTION') === 'rtl' ? 'rtl' : 'ltr' }}">
<!-- BEGIN: Head-->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin | @yield('title') | ChinaScore</title>
    <link rel="apple-touch-icon" href="{{asset('images/favicon/apple-touch-icon-152x152.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/favicon/favicon-32x32.png')}}">

    {{-- Include core + vendor Styles --}}
    @include('panels.styles')

</head>
<!-- END: Head-->


<!-- BEGIN: verticalLayoutMaster -->
<body
    class="{{$configData['mainLayoutTypeClass']}} @if(!empty($configData['bodyCustomClass']) && isset($configData['bodyCustomClass'])) {{$configData['bodyCustomClass']}} @endif @if($configData['isMenuCollapsed'] && isset($configData['isMenuCollapsed'])){{'menu-collapse'}} @endif"
    data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">

<!-- BEGIN: Header-->
<header class="page-topbar" id="header">
    @include('panels.navbar')
</header>
<!-- END: Header-->

<!-- BEGIN: SideNav-->
@include('panels.adminSidebar')
<!-- END: SideNav-->

<!-- BEGIN: Page Main-->
<div id="main">
    <div class="row">
        @if ($configData["navbarLarge"] === true)
            @if(($configData["mainLayoutType"]) === 'vertical-modern-menu')
                {{-- navabar large  --}}
                <div
                    class="content-wrapper-before @if(!empty($configData['navbarBgColor'])) {{$configData['navbarBgColor']}} @else {{$configData["navbarLargeColor"]}} @endif">
                </div>
            @else
                {{-- navabar large  --}}
                <div class="content-wrapper-before {{$configData["navbarLargeColor"]}}">
                </div>
            @endif
        @endif


        @if($configData["pageHeader"] === true && isset($breadcrumbs))
            {{--  breadcrumb --}}
            @include('panels.breadcrumb')
        @endif
        <div class="col s12">
            <div class="container">
                {{-- main page content --}}
                @yield('content')
                {{-- right sidebar --}}
                @include('pages.sidebar.right-sidebar')
                @if($configData["isFabButton"] === true)
                    @include('pages.sidebar.fab-menu')
                @endif
            </div>
            {{-- overlay --}}
            <div class="content-overlay"></div>
        </div>
    </div>
</div>
<!-- END: Page Main-->


@if($configData['isCustomizer'] === true)
    <!-- Theme Customizer -->
    @include('pages.partials.customizer')
    <!--/ Theme Customizer -->
    {{-- buy now button --}}
    @include('pages.partials.buy-now')
@endif


{{-- footer  --}}
@include('panels.footer')
{{-- vendor and page scripts --}}
@include('panels.scripts')
</body>
<!-- END: verticalLayoutMaster -->


</html>
