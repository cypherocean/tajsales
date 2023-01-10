<nav id="navbar" class="navbar">
    <ul>
        <li><a class="@if(\Request::route()->getName() == '' || \Request::route()->getName() == 'home') active @endif" href="{{ route('home') }}">Home</a></li>
        <li><a class="@if(\Request::route()->getName() == 'about') active @endif" href="{{ route('about') }}">About</a></li>
        <li><a class="@if(\Request::route()->getName() == 'product') active @endif" href="{{ route('product') }}">Products</a></li>
        <li class="d-none"><a class="@if(\Request::route()->getName() == 'client') active @endif " href="{{ route('client') }}">Clients</a></li>
        <li><a class="@if(\Request::route()->getName() == 'contact') active @endif" href="{{ route('contact') }}">Contact</a></li>
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav><!-- .navbar -->