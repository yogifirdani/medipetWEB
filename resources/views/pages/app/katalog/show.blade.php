@extends('layouts.app-cust')

@section('title', 'Detail Item')


@section('main')
<div class="main-content">
    <section class="section" >
        <div class="section-header">
            <h1>Detail Produk</h1>
        </div>

        <div class="container mx-auto px-4 py-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $product->nama }}</h2>
                </div>
                <div class="card-body">
                    <div class="media">
                        <!-- Product Image -->
                        <img class="mr-3"
                            src="{{ asset('product/' . $product->image) }}"
                            alt="{{ $product->nama }}" style="max-width: 500px; border-radius: 20px;">

                        <!-- Product Details -->
                        <div class="media-body">
                            <h5 class="mt-0">Rp.{{ number_format($product->harga, 2) }}</h5>

                            <p class="mt-5 px-4">{{ $product->deskripsi }}</p>

                            <div class="mb-3 px-4">
                                <p class="text-sm text-gray-500 mb-1">Stok: {{ $product->stok }}</p>
                                <p class="text-sm text-gray-500 mb-1">Kadaluarsa: {{ $product->kadaluarsa }}</p>
                            </div>

                            <form action="{{ route('catalogs.addToCart', $product->id) }}" method="POST" class="mt-9 px-4">
                                @csrf
                                <button type="submit" class="btn btn-primary mt-5">Tambah ke Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
        </div>

    </section>
</div>

@endsection
@push('scripts')
    <!-- JS Libraies -->
    {{--
    @section('js')
    @endsection
    --}}
@endpush
