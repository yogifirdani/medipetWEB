@extends('layouts.app')

@section('title', 'Data Pemasukan')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Penjualan</h1>
            </div>

            <div class="section-body">
                <div class="col-12">
                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Data Penjualan</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="{{ route('laporan.pemasukan') }}">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <select name="month" class="form-control">
                                            <option value="">Pilih Bulan</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ $i == $month ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="year" class="form-control">
                                            <option value="">Pilih Tahun</option>
                                            @for ($i = 2020; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}" {{ $i == $year ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary me-2">Filter</button>
                                        <a href="{{ route('laporan.pemasukan.pdf', ['month' => $month, 'year' => $year]) }}"
                                            class="btn btn-success">Print PDF</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                @php
                                    // Menghitung total pendapatan dari produk
                                    $totalProductRevenue = $productOrders->sum(function ($order) {
                                        return $order->total_quantity * ($order->product->harga ?? 0);
                                    });

                                    // Menghitung total pendapatan dari layanan
                                    $totalServiceRevenue = $serviceBookings->sum(function ($booking) {
                                        return $booking->total_bookings * ($booking->category->price ?? 0);
                                    });

                                    // Total pendapatan adalah akumulasi dari produk dan layanan
                                    $totalRevenue = $totalProductRevenue + $totalServiceRevenue;

                                    // Menghitung total pembelian dari produk
                                    $totalProductPurchases = $productOrders->sum('total_quantity');

                                    // Menghitung total pembelian dari layanan
                                    $totalServicePurchases = $serviceBookings->sum('total_bookings');

                                    // Total pembelian adalah akumulasi dari produk dan layanan
                                    $totalPurchases = $totalProductPurchases + $totalServicePurchases;
                                @endphp

                                <div class="container">
                                    <table class="table table-bordered text-center mt-4">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="font-size: 1.5rem;">Total Pendapatan:</th>
                                                <th style="font-size: 1.5rem;">Total Penjualan:</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <h5 class="mb-0"><strong
                                                            style="font-size: 1.5rem;">{{ number_format($totalRevenue, 2, ',', '.') }}</strong>
                                                    </h5>
                                                </td>
                                                <td>
                                                    <h5 class="mb-0"><strong
                                                            style="font-size: 1.5rem;">{{ $totalPurchases }}</strong></h5>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <h5 class="mt-4">Data Penjualan Produk</h5>
                                <table class="table table-striped table-bordered mt-2">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Produk</th>
                                            <th>Harga Satuan (Rp)</th>
                                            <th>Total Terjual (Pcs)</th>
                                            <th>Total (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productOrders as $order)
                                            <tr>
                                                <td>{{ $order->product ? $order->product->nama_produk : 'Produk Tidak Ditemukan' }}</td>
                                                <td>{{ $order->product->harga }}</td>
                                                <td class="text-center">{{ $order->total_quantity }}</td>
                                                <td class="text-end">
                                                    {{ $order->product ? number_format($order->total_quantity * $order->product->harga, 2, ',', '.') : '0' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($unsoldProducts as $product)
                                            <tr>
                                                <td>{{ $product->nama_produk }}</td>
                                                <td>{{ $product->harga }}</td>
                                                <td class="text-center">0</td>
                                                <td class="text-end">0</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <h5 class="mt-4">Data Layanan</h5>
                                <table class="table table-striped table-bordered mt-2">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Layanan</th>
                                            <th>Harga Satuan (Rp)</th>
                                            <th>Total Dipesan</th>
                                            <th>Total (Rp)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($serviceBookings as $booking)
                                            <tr>
                                                <td>{{ $booking->category->service_category }}</td>
                                                <td>{{  $booking->category->price }}</td>
                                                <td class="text-center">{{ $booking->total_bookings }}</td>
                                                <td class="text-end">
                                                    {{ number_format($booking->total_bookings * ($booking->category->price ?? 0), 2, ',', '.') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        @foreach ($unsoldServices as $service)
                                            <tr>
                                                <td>{{ $service->service_category }}</td>
                                                <td>{{ $service->price }}</td>
                                                <td class="text-center">0</td>
                                                <td class="text-end">0</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if ($productOrders->isEmpty() && $serviceBookings->isEmpty())
                                <p class="mt-3 text-center">Tidak ada data penjualan untuk bulan dan tahun yang dipilih.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
