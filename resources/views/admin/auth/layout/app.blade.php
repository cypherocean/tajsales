<!DOCTYPE html>
<html>

<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    @yield('meta')

    <title>@yield('title') | {{ _settings('SITE_TITLE') }}</title>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ _fevicon() }}">
    
    <link href="{{ asset('backend/assets/dist/css/style.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/extra-libs/toastr/toastr.min.css') }}" rel="stylesheet" />

    @yield('styles')
</head>
<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        @yield('content')
    </div>

    <script src="{{ asset('backend/assets/libs/jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/assets/libs/popper.js/dist/umd/popper.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('backend/assets/js/toastr.js') }}" type="text/javascript"></script>

    <script>
        $(".preloader ").fadeOut();
    </script>

    <script>
        toastr.options = {
            "progressBar": true,
            "positionClass": "toast-bottom-left",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
        
        @php
            $success = '';
            if(\Session::has('success'))
                $success = \Session::get('success');

            $error = '';
            if(\Session::has('error'))
                $error = \Session::get('error');
        @endphp

        var success = "{{ $success }}";
        var error = "{{ $error }}";

        if(success != ''){
            toastr.success(success, 'Success');
        }

        if(error != ''){
            toastr.error(error, 'error');
        }
    </script>

    @yield('scripts')
</body>

</html>