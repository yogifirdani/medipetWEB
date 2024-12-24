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
                                    <select name="filter" class="form-control" style="max-width: 200px;">
                                        <option value="">Pilih Riwayat</option>
                                        <option value="layanan" {{ request('filter') == 'layanan' ? 'selected' : '' }}>
                                            Pemesanan Layanan</option>
                                        <option value="produk" {{ request('filter') == 'produk' ? 'selected' : '' }}>
                                            Pemesanan Produk</option>
                                    </select>
                                    <select name="bulan" class="form-control mx-2" style="max-width: 200px;">
                                        <option value="">Bulan</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}"
                                                {{ request('bulan') == $month ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <select name="tahun" class="form-control mx-2" style="max-width: 200px;">
                                        <option value="">Tahun</option>
                                        @foreach (range(date('Y'), 2000) as $year)
                                            <option value="{{ $year }}"
                                                {{ request('tahun') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-primary p-2"
                                        style="font-size: 18px">Filter</button>
                                </div>
                            </form>

                            @if (isset($filter) && $filter == 'produk')
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Gambar</th>
                                            <th class="text-center">Pesanan</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Total Harga</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Faktur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $number = 1; @endphp
                                        @forelse ($data as $id_order => $orderGroup)
                                            @php
                                                $rowspan = $orderGroup->first()->detail->count();
                                                $totalHarga = $orderGroup->first()->detail->sum(function ($detail) {
                                                    return $detail->jumlah_pembelian * $detail->product->harga;
                                                });
                                            @endphp
                                            @foreach ($orderGroup->first()->detail as $index => $detail)
                                                <tr>
                                                    @if ($index === 0)
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">{{ $number++ }}</td>
                                                    @endif
                                                    <td class="text-center" style="align-content: center;">
                                                        <img src="{{ url('/product/' . $detail->product->image) }}"
                                                            alt="Product Image" width="50">
                                                    </td>
                                                    <td class="text-center" style="align-content: center;">
                                                        {{ $detail->product->nama_produk ?? '-' }}</td>
                                                    <td class="text-center" style="align-content: center;">
                                                        {{ $detail->product->kategori ?? '-' }}</td>
                                                    <td class="text-center" style="align-content: center;">
                                                        {{ $detail->jumlah_pembelian }} pcs</td>
                                                    @if ($index === 0)
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            Rp. {{ number_format($totalHarga, 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            {{ $orderGroup->first()->created_at->format('d-m-Y') }}
                                                        </td>
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            {{ $orderGroup->first()->status_pesanan }}
                                                        </td>
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            <a href="{{ route('invoice', ['id' => $id_order]) }}"
                                                                class="btn btn-warning btn-sm">Nota</a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Data kosong...</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @elseif (isset($filter) && $filter == 'layanan')
                                <table class="table table-bordered table-md">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="align-content: center;">No</th>
                                            <th class="text-center" style="align-content: center;">Nama Layanan</th>
                                            <th class="text-center" style="align-content: center;">Nama Hewan</th>
                                            <th class="text-center" style="align-content: center;">Jenis Hewan</th>
                                            <th class="text-center" style="align-content: center;">Tanggal Booking</th>
                                            <th class="text-center" style="align-content: center;">Jam</th>
                                            <th class="text-center" style="align-content: center;">Total Harga</th>
                                            <th class="text-center" style="align-content: center;">Status</th>
                                            <th class="text-center" style="align-content: center;">Faktur</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($data as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->category->service_category }}</td>
                                                <td class="text-center">{{ $item->pet_name }}</td>
                                                <td class="text-center">{{ $item->pet_type }}</td>
                                                <td class="text-center">{{ $item->booking_date }}</td>
                                                <td class="text-center">{{ $item->start_time }}</td>
                                                <td class="text-center">Rp
                                                    {{ number_format($item->total_price, 0, ',', '.') }}</td>
                                                <td class="text-center">{{ $item->status }}</td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic example">
                                                        <a href="{{ route('kwitansi', ['id' => $item->id]) }}"
                                                            class="btn btn-info btn-sm">Kwitansi</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">Data kosong...</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            @else
                                <p class="text-center mt-5">Silakan pilih riwayat pesanan yang ingin ditampilkan.</p>
                            @endif
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
