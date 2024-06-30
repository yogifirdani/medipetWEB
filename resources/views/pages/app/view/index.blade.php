@extends('layouts.app-cust')

@section('title', 'View')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-breadcrumb" style="height: 32px;">
                </div>
            </div>
            <div class="card rounded-4 mt-6">
                <div class="card-body p-4">
                    <div class="col-12">
                        <h2 class="text-left mb-4">Riwayat Pesanan</h2>
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th class="text-center">Pesanan</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Jumlah Pembelian</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($manage_order as $orders)
                                        <tr>
                                            {{-- <td class="text-center">{{ $user->nama }}</td> --}}
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            {{-- <td class="text-center">{{ $orders->product->kategori }}</td>
                                            <td class="text-center">{{ $orders->jumlah_pembelian }}</td>
                                            <td class="text-center">{{ $orders->product->price }}</td>
                                            <td class="text-center">Rp {{ number_format($orders->harga_produk, 0, ',', '.') }}</td>
                                            <td class="text-center">Rp {{ number_format($orders->total_harga, 0, ',', '.') }}</td>
                                            <td class="text-center">
                                                @if ($orders->status_pesanan == 'belum_bayar')
                                                    <span class="badge badge-secondary">Belum Dibayar</span>
                                                @elseif ($orders->status_pesanan == 'diproses')
                                                    <span class="badge badge-warning">Diproses</span>
                                                @elseif ($orders->status_pesanan == 'dikirim')
                                                    <span class="badge badge-info">Dikirim</span>
                                                @elseif ($orders->status_pesanan == 'selesai')
                                                    <span class="badge badge-success">Selesai</span>
                                                @else
                                                    <span class="badge badge-danger">Dibatalkan</span>
                                                @endif --}}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">Data kosong...</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
