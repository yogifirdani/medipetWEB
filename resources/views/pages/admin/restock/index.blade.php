@extends('layouts.app')

@section('title', 'Restock Table')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Restock</h1>
            </div>

            <div class="section-body">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('restocks.create') }}" class="btn btn-primary mt-5">
                    <h5>Tambah Pembelian</h5>
                </a>

                @if ($restocks->isEmpty())
                    <p class="mt-3">Belum ada restock.</p>
                @else
                    <div class="card">
                        <div class="card-header">
                            <div class="search-element">
                                <form action="{{ route('restocks.index') }}" class="form-inline" method="GET">
                                    <input class="form-control" type="search" name="q" placeholder="Search"
                                        aria-label="Search" data-width="350" value="{{ request('q') }}">
                                    <input class="form-control" type="date" name="tanggal" placeholder="Tanggal Pembelian">

                                    <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                                </form>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table-striped table-md table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nama Produk</th>
                                            <th>Kuantitas</th>
                                            <th>Harga Satuan</th>
                                            <th>Total Harga</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($restocks as $restock)
                                            <tr>
                                                <td>{{ $restock->id_restock }}</td>
                                                <td>{{ $restock->product->nama_produk ?? 'Produk tidak ada' }}</td>
                                                <td>{{ $restock->quantity }}</td>
                                                <td>{{ number_format($restock->harga_satuan, 0, ',', '.') }}</td>
                                                <td>{{ number_format($restock->total_harga, 0, ',', '.') }}</td>
                                                <td>{{ $restock->tanggal_pembelian }}</td>
                                                <td>
                                                    <form action="{{ url('/restocks/' . $restock->id_product) }}"
                                                        method="POST">
                                                        <a href="{{ route('restocks.edit', $restock->id_restock) }}"
                                                            class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                            title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                        @csrf
                                                        {{-- @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-action"
                                                            onclick="return confirm('Yakin ingin menghapus restock ini?')"><i
                                                                class="fas fa-trash"></i></button> --}}
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/components-table.js') }}"></script>
@endpush
