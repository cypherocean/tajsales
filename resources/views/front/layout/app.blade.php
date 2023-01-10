<!DOCTYPE html>
<html lang="en">

<head>
    @include('front.layout.meta')
    <!-- Favicons -->
    <title>Taj Sales - @yield('title')</title>

    @include('front.layout.style')

</head>

<body>

    @include('front.layout.header')
    
    
    @yield('content')
    
    
    @include('front.layout.footer')
    
    
    @include('front.layout.scripts')

</body>

</html>