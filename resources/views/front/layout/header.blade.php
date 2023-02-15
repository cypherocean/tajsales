<!-- ======= Top Bar ======= -->
<section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
            <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:{{ _settings('CONTACT_EMAIL') }}" style="color: white">{{ _settings('CONTACT_EMAIL') }}</a></i>
            <i class="bi bi-phone d-flex align-items-center ms-4"><span style="color: white">{{ _settings('CONTACT_NUMBER') }}</span></i>
            <i class="bi bi-phone d-flex align-items-center ms-4"><span style="color: white">{{ _settings('ALTERNATE_CONTACT_NUMBER') }}</span></i>
            <i class="bi bi-phone d-flex align-items-center ms-4"><span style="color: white">{{ _settings('MAIN_CONTACT_NUMBER') }}</span></i>
        </div>
    </div>
</section>

<!-- ======= Header ======= -->
<header id="header" class="d-flex align-items-center" style="background: #4d4643;">
    <div class="container d-flex justify-content-between">

        <div class="logo">
            <!--<h1 class="text-light"><a href="index.html">Flattern</a></h1>-->
            <!-- Uncomment below if you prefer to use an image logo -->
            
            <a href="{{ route('home') }}"><img src="{{ _logo() }}" alt="" class="img-fluid"></a>
        </div>

        @include('front.layout.menu')

    </div>
</header><!-- End Header -->