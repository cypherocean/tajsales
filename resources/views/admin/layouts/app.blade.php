
<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    @include('admin.layouts.meta')

    <title>@yield('title') | {{ _settings('SITE_TITLE') }}</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ _fevicon() }}">
    
    @include('admin.layouts.styles')
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        @include('admin.layouts.header')
        
        @include('admin.layouts.sidebar')

        <div class="page-wrapper">
            @yield('content')

            @include('admin.layouts.footer')
        </div>
    </div>

    @include('admin.layouts.scripts')
</body>
</html>