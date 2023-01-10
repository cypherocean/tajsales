@extends('front.layout.app')

@section('meta')
@endsection

@section('title')
Product Details
@endsection

@section('styles')

@endsection

@section('content')
<main id="main">

<!-- ======= Breadcrumbs ======= -->
<section id="breadcrumbs" class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2>Product Details</h2>
      <ol>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li>Product Details</li>
      </ol>
    </div>

  </div>
</section><!-- End Breadcrumbs -->

<!-- ======= Portfolio Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
  <div class="container">

    <div class="row gy-4">

      <div class="col-lg-8">
        <div class="portfolio-details-slider swiper">
          <div class="swiper-wrapper align-items-center">
            @if(!empty($product_images))
              @foreach($product_images AS $image)
                <div class="swiper-slide">
                  <img src="{{ $image->image }}" alt="">
                </div>
              @endforeach
            @endif
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="portfolio-info">
          <h3>Project information</h3>
          <ul>
            <li><strong>Category</strong>: {{ $products->category_name ?? '' }}</li>
            <li><strong>Name</strong>: {{ $products->title ?? '' }}</li>
            <!-- <li><strong>Project date</strong>: 01 March, 2020</li>
            <li><strong>Project URL</strong>: <a href="#">www.example.com</a></li> -->
          </ul>
        </div>
        <div class="portfolio-description">
          <h2>Product Details</h2>
          <p>
            {{ $products->product_description }}
          </p>
        </div>
      </div>

    </div>

  </div>
</section><!-- End Portfolio Details Section -->

</main><!-- End #main -->
@endsection

@section('scripts')
@endsection