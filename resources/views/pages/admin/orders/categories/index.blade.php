@extends('layouts.app')

@section('title', 'Daftar Booking')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Kategori Layanan</h1>
        </div>

        <div class="section-body">
            <div class="col-12 col-md-12 col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('categories.create') }}" class="btn btn-primary mt-5">
                    <h5>Tambah Kategori</h5>
                </a>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Daftar Kategori</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-bordered table-md table">
                                <tr>
                                    <th>Id</th>
                                    <th>Jenis Layanan</th>
                                    <th>Jenis Hewan</th>
                                    <th>Jam Layanan</th>
                                    <th>Layanan Satu Hari</th>
                                    <th>Harga</th>
                                    <th>Aksi</th>
                                </tr>
                                @foreach ($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->service_category }}</td>
                                        <td>{{ $category->pet_category }}</td>
                                        <td>{{ $category->service_time }}</td>
                                        <td>{{ $category->take_status }}</td>
                                        <td>{{ $category->price }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
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
