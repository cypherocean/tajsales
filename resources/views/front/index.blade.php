@extends('front.layout.app')

@section('meta')
@endsection

@section('title')
Home
@endsection

@section('styles')

@endsection

@section('content')
<!-- ======= Hero Section ======= -->
<section id="hero">
  <div id="heroCarousel" data-bs-interval="5000" class="carousel slide carousel-fade" data-bs-ride="carousel">

    <div class="carousel-inner" role="listbox">

      <!-- Slide 1 -->
      <div class="carousel-item active" style="background-image: url(frontend/assets/img/slide/slide1.jpg);">
        <div class="carousel-container">
          <div class="carousel-content animate__animated animate__fadeInUp">
            <h2>Welcome to <span>Taj Sales</span></h2>
            <p class="d-none">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam.
              Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus
              deleniti vel. Minus et tempore modi architecto.</p>
            <div class="text-center"><a href="{{ route('about') }}" class="btn-get-started">Read More</a></div>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="carousel-item" style="background-image: url(frontend/assets/img/slide/slide2.jpg);">
        <div class="carousel-container">
          <div class="carousel-content animate__animated animate__fadeInUp">
            <h2>Taj Sales</h2>
            <p class="d-none">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam.
              Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus
              deleniti vel. Minus et tempore modi architecto.</p>
            <div class="text-center"><a href="{{ route('about') }}" class="btn-get-started">Read More</a></div>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="carousel-item" style="background-image: url(frontend/assets/img/slide/slide3.jpg);">
        <div class="carousel-container">
          <div class="carousel-content animate__animated animate__fadeInUp">
            <h2>Taj Sales</h2>
            <p class="d-none">Ut velit est quam dolor ad a aliquid qui aliquid. Sequi ea ut et est quaerat sequi nihil ut aliquam.
              Occaecati alias dolorem mollitia ut. Similique ea voluptatem. Esse doloremque accusamus repellendus
              deleniti vel. Minus et tempore modi architecto.</p>
            <div class="text-center"><a href="{{ route('about') }}" class="btn-get-started">Read More</a></div>
          </div>
        </div>
      </div>

    </div>

    <a class="carousel-control-prev" href="#heroCarousel" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon bx bx-left-arrow" aria-hidden="true"></span>
    </a>

    <a class="carousel-control-next" href="#heroCarousel" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon bx bx-right-arrow" aria-hidden="true"></span>
    </a>

    <ol class="carousel-indicators" id="hero-carousel-indicators"></ol>

  </div>
</section><!-- End Hero -->

<main id="main" style="background-color: #4d4643">

  <!-- ======= Cta Section ======= -->
  <section id="cta" class="cta">
    <div class="container">

      <div class="row">
        <div class="col-lg-9 text-center text-lg-left">
          <h3>We've have more than <span>500 satisfied clients</span> around the world!</h3>
          <p> Our mission is to provide quality products to our clients. We are committed to provide satisfaction to our
            each and every customer we serve.</p>
        </div>
        <div class="col-lg-3 cta-btn-container text-center">
          <a class="cta-btn align-middle" href="mailto:tajsales111@gmail.com">Request a quote</a>
        </div>
      </div>

    </div>
  </section><!-- End Cta Section -->

  <!-- ======= Services Section ======= -->

  <section id="services" class="services">
    <div class="container">
      <h3 style="color: white; margin-bottom: 30px">Our Top Products</h3>
      <div class="row">
        @if(!empty($product_images))
          @foreach($product_images AS $image)
            <div class="col-lg-4 col-md-6">
              <div class="icon-box" data-aos="fade-up">
              <div class="member-img">
                <img src="{{ $image->image }}" class="img-fluid" alt="{{ $image->category_name }}" style="object-fit: contain; width: 150px; height: 100px;">
              </div>
                <h4 class="title"><a href="{{ route('product_detail', ['id' => base64_encode($image->product_id)]) }}">{{ $image->title }}</a></h4>
                </div>
              </div>
            @endforeach
          @endif
      </div>

    </div>
  </section><!-- End Services Section -->



</main><!-- End #main -->
@endsection

@section('scripts')
@endsection