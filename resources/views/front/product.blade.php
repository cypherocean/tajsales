@extends('front.layout.app')

@section('meta')
@endsection

@section('title')
Products
@endsection

@section('styles')

@endsection

@section('content')
<main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
        <div class="container">

            <div class="d-flex justify-content-between align-items-center">
                <h2>Products</h2>
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>Products</li>
                </ol>
            </div>

        </div>
    </section><!-- End Breadcrumbs -->

    <section id="portfolio" class="portfolio">
        <div class="container">

            <div class="row" data-aos="fade-up">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul id="portfolio-flters">
                        <li data-filter="*" class="filter-active">All</li>
                        @if(!empty($categories))
                            @foreach($categories AS $category)
                            @php $cat_name = strtolower(preg_replace('/[\W\s\/]+/', '', $category->name)) ; @endphp
                                <li data-filter=".{{ $cat_name }}" class="mb-1">{{ $category->name }}</li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            <div class="row portfolio-container" data-aos="fade-up">
                @if(!empty($product_images))
                    @foreach($product_images AS $product)
                        @php $cat_name = strtolower(preg_replace('/[\W\s\/]+/', '', $product->category_name)) ; @endphp
                        <div class="col-lg-4 col-md-6 portfolio-item {{ preg_replace('/\s+/', '_', $cat_name) }}">
                            <img src="{{ $product->image }}" class="img-fluid" alt="">
                            <div class="portfolio-info">
                                <h4>{{ $product->title }}</h4>
                                <p>{{ $product->category_name }}</p>
                                <a href="{{ $product->image }}" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="{{ $product->title }}"><i class="bx bx-plus"></i></a>
                                <a href="{{ route('product_detail', ['id' => base64_encode($product->product_id)]) }}" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
</main><!-- End #main -->
@endsection

@section('scripts')
@endsection