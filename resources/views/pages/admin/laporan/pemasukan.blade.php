@extends('layouts.app')

@section('title', 'Data Pemasukan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Penjualan</h1>
        </div>

        <div class="section-body">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Data Penjualan</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('laporan.pemasukan') }}">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <select name="data_type" class="form-control">
                                        <option value="">Pilih Data</option>
                                        <option value="services" {{ (isset($data_type) && $data_type == 'services') ? 'selected' : '' }}>Pemesanan Layanan</option>
                                        <option value="products" {{ (isset($data_type) && $data_type == 'products') ? 'selected' : '' }}>Pemesanan Produk</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('laporan.pemasukan.pdf', ['data_type' => $data_type]) }}" class="btn btn-success">Print PDF</a>
                                </div>
                            </div>
                        </form>

                        @if (isset($data_type) && $data_type == 'services')
                            {{-- <h5>Data Pemesanan Layanan</h5> --}}
                            <div class="table-responsive">
                                <table class="table-bordered table-md table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Telepon</th>
                                            <th>Nama Layanan</th>
                                            <th>Kuantitas</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $index = 1; @endphp
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $booking->name }}</td>
                                                <td>{{ $booking->phone }}</td>
                                                <td>{{ $booking->category->service_category }}</td>
                                                <td>1</td>
                                                <td>{{ $booking->booking_date }}</td>
                                                <td>{{ $booking->total_price }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @elseif (isset($data_type) && $data_type == 'products')
                            {{-- <h5>Data Pemesanan Produk</h5> --}}
                            <div class="table-responsive">
                                <table class="table-bordered table-md table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Telepon</th>
                                            <th>Nama Produk</th>
                                            <th>Kuantitas</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $index = 1; @endphp
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>-</td>
                                                <td>-</td>
                                                <td>{{ $order->product->nama_produk }}</td>
                                                <td>{{ $order->jumlah_pembelian }}</td>
                                                <td>{{ $order->created_at }}</td>
                                                <td>{{ $order->total_harga }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p>Silakan pilih jenis data yang ingin ditampilkan.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
