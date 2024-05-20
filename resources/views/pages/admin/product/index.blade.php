@extends('layouts.app')

@section('title', 'Manage Item')

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
                            <h4></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-bordered table-md table">
                                    <tr>
                                        <th>Id</th>
                                        <th>Gambar</th>
                                        <th>Nama</th>
                                        <th>Kategori</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                    @foreach ($products as $product)
                                        <tr>
                                            <td>{{ $product->id }}</td>
                                            <td><img src="{{ url('/product/' . $product->image) }}" alt="" width="100"></td>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->category }}</td>
                                            <td>{{ $product->stok }}</td>
                                            <td>{{ $product->price }}</td>
                                            <td>{{ $product->deskripsi }}</td>
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
