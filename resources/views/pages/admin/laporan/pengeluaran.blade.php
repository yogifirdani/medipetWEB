@extends('layouts.app')

@section('title', 'Data Pengeluaran')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Data Pengeluaran</h1>
        </div>

        <div class="section-body">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Data Pengeluaran</h4>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('laporan.pengeluaran') }}">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <select name="month" class="form-control">
                                        <option value="">Pilih Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}" {{ (isset($month) && $month == $i) ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="year" class="form-control">
                                        <option value="">Pilih Tahun</option>
                                        @for ($i = date('Y'); $i >= 2000; $i--)
                                            <option value="{{ $i }}" {{ (isset($year) && $year == $i) ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('laporan.pengeluaran.pdf') }}" class="btn btn-success">Print PDF</a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table-bordered table-md table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Transaksi</th>
                                        <th>Nama Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga Satuan</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $index = 1; @endphp
                                    @foreach ($restocks as $restock)
                                        <tr>
                                            <td>{{ $index++ }}</td>
                                            <td>{{ $restock->tanggal_pembelian }}</td>
                                            <td>Restock</td>
                                            <td>{{ $restock->product->nama_produk }}</td>
                                            <td>{{ $restock->quantity }}</td>
                                            <td style="text-align: right;">{{ $restock->harga_satuan }}</td>
                                            <td style="text-align: right;">{{ $restock->total_harga }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</ div>
@endsection
