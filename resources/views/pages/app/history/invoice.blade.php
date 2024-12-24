@extends('layouts.app-cust')

@section('title', 'Invoice')

@push('style')
    <style>
        .invoice {
            max-width: 850px;
            margin: 0 auto;
            padding: 15px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Nota Pesanan</h1>
            </div>

            <div class="section-body">
                <div class="invoice">
                    <div class="invoice-print">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="invoice-title">
                                    <h2>Nota Pesanan</h2>
                                    <p class="text-center">No. Pesanan #{{ $order->id_orders }}</p>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Data Pemesan:</strong><br>
                                            <div class="mt-2 px-3">{{ Auth::user()->name }}</div>
                                            <div class="px-3">{{ Auth::user()->email }}</div>
                                            <div class="px-3">{{ Auth::user()->phone }}</div>
                                            <div class="mb-5 px-3">{{ Auth::user()->address }}</div>
                                        </address>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <address>
                                            <strong>Metode Pembayaran:</strong><br>
                                            {{ $order->co->atm ?? 'N/A' }}<br>
                                        </address>
                                    </div>
                                    <div class="col-md-6 text-md-right">
                                        <address>
                                            <strong>Tanggal Pesanan:</strong><br>
                                            {{ $order->created_at->format('d F, Y') }}<br><br>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Rincian Pesanan</div>
                                <div class="table-responsive">
                                    <table class="table-light table-bordered table-md table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Gambar</th>
                                                <th class="text-center">Pesanan</th>
                                                <th class="text-center">Jumlah Pembelian</th>
                                                <th class="text-center">Harga</th>
                                                <th class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $totalKeseluruhan = 0; @endphp
                                            @foreach ($order->detail as $index => $detail)
                                                @php
                                                    $subtotal = $detail->jumlah_pembelian * $detail->product->harga;
                                                    $totalKeseluruhan += $subtotal;
                                                @endphp
                                                <tr>
                                                    <td class="text-center" style="align-content: center;">
                                                        {{ $index + 1 }}</td>
                                                    <td class="text-center" style="align-content: center;">
                                                        @if ($detail->product->image)
                                                            <img src="{{ url('/product/' . $detail->product->image) }}"
                                                                alt="Product Image" width="100">
                                                        @else
                                                            <span>-</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center" style="align-content: center;">
                                                        {{ $detail->product->nama_produk }}</td>
                                                    <td class="text-center" style="align-content: center;">
                                                        {{ $detail->jumlah_pembelian }} psc</td>
                                                    <td class="text-right" style="align-content: center;">Rp
                                                        {{ number_format($detail->product->harga ?? 0, 0, ',', '.') }}</td>
                                                    <td class="text-right" style="align-content: center;">Rp
                                                        {{ number_format($subtotal ?? 0, 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-4">
                                    <div class="text-right float-lg-end">
                                        <hr class="mb-2">
                                        <div class="invoice-detail-item">
                                            <div class="invoice-detail-name">Total Pembayaran</div>
                                            <div class="invoice-detail-value invoice-detail-value-lg">Rp
                                                {{ number_format($totalKeseluruhan, 0, ',', '.') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-md-center">
                        <div class="float-lg-end mb-lg-0 mb-3">
                            <a href="{{ route('history.index') }}" class="btn btn-success" style="margin-left: 30px;">
                                Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush
