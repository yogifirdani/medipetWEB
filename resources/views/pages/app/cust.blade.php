@extends('layouts.app-cust')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-breadcrumb" style="height: 32px;">
                </div>
            </div>

            <!-- Slide Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="img/slider/slide1.jpeg" alt="First slide" height="450">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>First Slide</h5>
                                    <p>First slide description.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="img/slider/slide2.jpeg" alt="Second slide" height="450">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Second Slide</h5>
                                    <p>Second slide description.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img class="d-block w-100" src="img/slider/slide3.jpeg" alt="Third slide" height="450">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>Third Slide</h5>
                                    <p>Third slide description.</p>
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- End of Slide Section -->

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Janji temu</h4>
                            </div>
                            <div class="card-body">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="far fa-newspaper"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Grooming</h4>
                            </div>
                            <div class="card-body">
                                {{-- {{App\Models.Product::jmlStok('Grooming') }} --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="far fa-file"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Vaksin</h4>
                            </div>
                            <div class="card-body">
                                {{-- {{App\Models.Product::jmlStok('Vaksin') }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a href="{{ route('catalogs.index') }}" class="text-right" style="font-size: 115%">
                <p>Lainnya <i class="fa-solid fa-angle-right"></i></p>
            </a>
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article">
                            <div class="article-header">
                                <div class="article-image"
                                    style="background-image: url('{{ asset("product/{$product->image}") }}');">
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-title">
                                    <h2><a href="{{ route('catalogs.show', $product->id) }}">{{ $product->nama }}</a></h2>
                                </div>
                            </div>
                            <p class="text-center">{{ Str::limit($product->deskripsi, 100) }}</p>
                            <p style="font-size: 120%" class="text-center">Rp. {{ $product->harga }}</p>
                        </article>
                    </div>
                @empty
                @endforelse
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
@endpush
