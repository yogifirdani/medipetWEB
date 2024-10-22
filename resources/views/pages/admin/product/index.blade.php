@extends('layouts.app')

@section('title', 'Manage Item')

@push('style')
    {{-- CSS Libraries --}}
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Mengelola Produk</h1>
            </div>

            <div class="section-body">
                <div class="col-12 col-md-12 col-lg-12">

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('products.add') }}" class="btn btn-primary mt-5">
                        <h5>Menambahkan Produk</h5></a>

                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="search-element">
                                <form action="{{ route('products.index') }}" class="form-inline" method="GET">
                                    <input class="form-control" type="search" name="q" placeholder="Search" aria-label="Search" data-width="350" value="{{ request('q') }}">
                                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                                </form>
                                <div class="search-backdrop"></div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-bordered table-md table">
                                    <tr>
                                        <th>Id</th>
                                        <th>Gambar</th>
                                        <th>Nama Produk</th>
                                        <th>Jenis Hewan</th>
                                        <th>Kategori</th>
                                        <th>Merek</th>
                                        <th>Berat</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Kadaluarsa</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td><img src="{{ url('/product/' . $product->image) }}" alt="" width="100"></td>
                                            <td>{{ $product->nama_produk }}</td>
                                            <td>{{ $product->jenis_hewan }}</td>
                                            <td>{{ $product->kategori }}</td>
                                            <td>{{ $product->merek }}</td>
                                            <td>{{ $product->berat }}</td>
                                            <td>{{ $product->stok }}</td>
                                            <td>{{ $product->harga }}</td>
                                            <td>{{ $product->deskripsi }}</td>
                                            <td>{{ $product->kadaluarsa }}</td>
                                            <td>
                                                <form action="{{ url('/products/' . $product->id) }}" method="POST">
                                                    <a href="{{ url('/products/' . $product->id . '/edit') }}"
                                                       class="btn btn-primary btn-action mr-1"
                                                       data-toggle="tooltip"
                                                       title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-action"
                                                            data-toggle="tooltip"
                                                            title="Delete"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
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
