@extends('layouts.app-cust')

@section('title', 'List Produk')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Katalog Produk</h1>
        </div>
        <div class="section-body">
            <!-- Search Form -->
            <form action="{{ route('catalogs.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari produk..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </div>
                </div>
            </form>

            <!-- Product List -->
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                        <article class="article">
                            <div class="article-header">
                                <div class="article-image" style="background-image: url('{{ asset("product/{$product->image}") }}');">
                                </div>
                            </div>
                            <div class="article-details">
                                <div class="article-title">
                                    <h2><a href="{{ route('catalogs.show', $product->id) }}">{{ $product->nama }}</a></h2>
                                    <p><h4>Rp. {{ $product->harga }}</h4></p>
                                </div>
                                {{-- <p>{{ Str::limit($product->deskripsi, 100) }}</p> --}}
                                <div class="article-cta">
                                    <a href="{{ route('catalogs.show', $product->id) }}" class="btn btn-primary">Beli Sekarang</a>
                                    {{-- <a class="btn btn-outline-secondary">IDR {{ number_format($product->harga, 0, ',', '.') }}</a> --}}
                                    <a href="{{ route('cart.addtocart', $product->id) }}" class="btn btn-primary">
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <p>Tidak ada produk ditemukan.</p>
                    </div>
                @endforelse
            </div>

            {{-- <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->withQueryString()->links() }}
            </div> --}}
        </div>
    </section>
</div>
@endsection
