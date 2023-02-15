@extends('front.layout.app')

@section('meta')
@endsection

@section('title')
About
@endsection

@section('styles')

@endsection

@section('content')
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>About</h2>
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>About</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= About Us Section ======= -->
    <section id="about-us" class="about-us">
        <div class="container">

            <div class="row no-gutters">
                <div class="image col-xl-5 d-flex align-items-stretch justify-content-center justify-content-lg-start" data-aos="fade-right"></div>
                <div class="col-xl-7 ps-0 ps-lg-5 pe-lg-1 d-flex align-items-stretch">
                    <div class="content d-flex flex-column justify-content-center">
                        <h3 data-aos="fade-up">About Taj Sales</h3>
                        <p data-aos="fade-up">
                            Established In 2011, we are based in Rajkot, one of the most rapidly growing Industrial arenas of Western India. Within a short span of time, with dedicated efforts and streamlined expertise, we have earned a name as Leading Manufacturer of Hardware Architectural Product. We cater to both Domestic and International markets. Consistent superior quality is what makes us stand out in the market.
                        </p>
                        <div class="row">
                            <div class="col-md-6 icon-box" data-aos="fade-up">
                                <i class="bx bx-receipt"></i>
                                <h4>Nature of Business</h4>
                                <p>Exporter and Manufacturer</p>
                            </div>
                            <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                <i class="bx bx-cube-alt"></i>
                                <h4>Trusted</h4>
                                <p>We offer manufacture the best quality and durable products we are trusted amoung our valued clients</p>
                            </div>
                            <div class="col-md-12 icon-box" data-aos="fade-up" data-aos-delay="200">
                                <i class="bx bx-images"></i>
                                <h4>Assured Quality</h4>
                                <p>All the manufacturing process and product finishing is done in house so we can assure you the best quality.</p>
                            </div>
                            
                        </div>
                    </div><!-- End .content-->
                </div>
            </div>

        </div>
    </section><!-- End About Us Section -->

    <!-- ======= Our Team Section ======= -->
    <section id="team" class="team section-bg">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>Our <strong>Team</strong></h2>
                <p class="d-none">Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
            </div>

            <div class="row">

                @if(!empty($teams))
                    @foreach($teams AS $team)
                        <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                            <div class="member" data-aos="fade-up">
                                <div class="member-img">
                                    <img src="{{ $team['image'] }}" class="img-fluid" alt="">
                                    <div class="social">
                                        <a href="{{ $team['twitter_url'] ?? '' }}"><i class="bi bi-twitter"></i></a>
                                        <a href="{{ $team['facebook_url'] ?? '' }}"><i class="bi bi-facebook"></i></a>
                                        <a href="{{ $team['instagram_url'] ?? '' }}"><i class="bi bi-instagram"></i></a>
                                        <a href="{{ $team['linked_in_url'] ?? '' }}"><i class="bi bi-linkedin"></i></a>
                                    </div>
                                </div>
                                <div class="member-info">
                                    <h4>{{ $team['name'] ?? 'John Doe' }}</h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif


            </div>

        </div>
    </section><!-- End Our Team Section -->



</main><!-- End #main -->
@endsection

@section('scripts')
@endsection