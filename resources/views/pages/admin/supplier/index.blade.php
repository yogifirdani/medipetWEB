@extends('layouts.app')

@section('title', 'Supplier List')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Daftar Supplier</h1>
            </div>

            <div class="section-body">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

              

                <a href="{{ route('suppliers.create') }}" class="btn btn-primary mt-5">
                    <h5>Tambah Supplier</h5>
                </a>

                @if ($suppliers->isEmpty())
                    <p class="mt-3">Belum ada supplier.</p>
                @else
                    <div class="card mt-4">
                        <div class="card-header">
                            <div class="search-element">
                                <form action="{{ route('suppliers.index') }}" method="GET" class="form-inline">
                                    <input type="text" class="form-control" name="q" placeholder="Search Supplier"
                                           value="{{ request('q') }}">
                                    <button type="submit" class="btn btn-primary ml-2">Cari</button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table-striped table-md table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nama Supplier</th>
                                            <th>Alamat</th>
                                            <th>Kontak</th>
                                            <th>ATM</th>
                                            <th>No Rekening</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($suppliers as $supplier)
                                            <tr>
                                                <td>{{ $supplier->id }}</td>
                                                <td>{{ $supplier->nama_supplier }}</td>
                                                <td>{{ $supplier->alamat }}</td>
                                                <td>{{ $supplier->kontak }}</td>
                                                <td>{{ $supplier->atm }}</td>
                                                <td>{{ $supplier->norek }}</td>
                                                <td>
                                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST">
                                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-primary btn-action mr-1" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-action" onclick="return confirm('Yakin ingin menghapus supplier ini?')"><i class="fas fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    @section('js')
    @endsection
@endpush
