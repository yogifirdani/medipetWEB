@extends('layouts.app')

@section('title', 'Manage Item')

@push('style')
    {{-- CSS Libraries --}}
@endpush


@section('content')
    <h1>{{ $product->nama }}</h1>
    <p>Jenis Hewan: {{ $product->jenis_hewan }}</p>
    <p>Kategori: {{ $product->kategori }}</p>
    <p>Merek: {{ $product->merek }}</p>
    <p>Berat: {{ $product->berat }}</p>
    <p>Stok: {{ $product->stok }}</p>
    <p>Harga: {{ $product->harga }}</p>
    <p>Deskripsi: {{ $product->deskripsi }}</p>
    <p>Kadaluarsa: {{ $product->kadaluarsa }}</p>

    <img src="{{ asset('product/' . $product->image) }}" alt="{{ $product->nama }}" style="max-width: 300px;">

    <a href="{{ route('catalogs.index') }}">Back to Catalog</a>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{--
    @section('js')
    @endsection
    --}}
@endpush
