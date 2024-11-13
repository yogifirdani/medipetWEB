@extends('layouts.app-cust')

@section('title', 'History')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Riwayat Pesanan</h1>
            </div>
            <div class="card rounded-4 mt-6">
                <div class="card-body p-4">
                    <div class="col-12">
                        <h2 class="text-left mb-3">Pesanan Anda</h2>
                        <div class="table-responsive">
                            <form method="GET" action="{{ route('history.index') }}" class="mb-2">
                                <div class="input-group">
                                    <select name="bulan" class="form-control" style="max-width: 130px;">
                                        <option value="">Bulan</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}" {{ request('bulan') == $month ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select name="tahun" class="form-control mx-2" style="max-width: 130px;">
                                        <option value="">Tahun</option>
                                        @foreach (range(date('Y'), 2000) as $year)
                                            <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary p-2" style="font-size: 18px">Filter</button>
                                </div>
                            </form>

                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Gambar</th>
                                        <th class="text-center">Pesanan</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Jumlah Pembelian</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($manage_orders as $order)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td><img src="{{ url('/product/' . $order->product->image) }}"
                                                    alt="Product Image" width="100"></td>
                                            <td class="text-center">{{ $order->product->nama_produk }}</td>
                                            <td class="text-center">{{ $order->product->kategori }}</td>
                                            <td class="text-center">{{ $order->jumlah_pembelian }}</td>
                                            <td class="text-center">Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                            </td>
                                            <td class="text-center">
                                                @if ($order->status_pesanan == 'proses')
                                                    <span class="badge badge-secondary">Proses</span>
                                                @elseif($order->status_pesanan == 'ditolak')
                                                    <span class="badge badge-danger">Pesanan ditolak</span>
                                                {{-- @elseif($order->status_pesanan == 'dikirim')
                                                    <span class="badge badge-success">Pesanan Dikirim</span> --}}
                                                @elseif($order->status_pesanan == 'lunas')
                                                    <span class="badge badge-success">Selesai</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Data kosong...</td>
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

@push('scripts')
    <!-- JS Libraries -->
@endpush
