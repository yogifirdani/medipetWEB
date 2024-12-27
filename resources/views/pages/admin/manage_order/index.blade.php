@extends('layouts.app')

@section('title', 'Table')

@push('style')
    <style>
        .card-custom {
            margin: 2px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Mengelola Pesanan</h1>
            </div>
            <div class="section-body">
                <div class="col-md-12">
                    <a href="{{ route('transaksi.create') }}" class="btn btn-primary mt-2 mb-2">
                        <h5>Tambah Pesanan</h5>
                    </a>
                </div>
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card pt-3 mt-3 card-custom">
                        <form method="GET" action="/transaksi" class="px-4 mb-4 mt-2">
                            <div class="input-group">
                                <strong class="mt-2" for="month">Bulan: </strong>
                                <select class="form-control mx-2" style="max-width: 120px;" aria-label="Default select example" name="month"
                                    id="month">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                                <strong class="mt-2" for="year">Tahun:</strong>
                                <select class="form-control mx-2" style="max-width: 120px;" aria-label="Default select example" name="year"
                                    id="year">
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                                <strong class="mt-2" for="kategori">Kategori:</strong>
                                <select class="form-control mx-2" style="max-width: 120px;" aria-label="Default select example" name="kategori"
                                    id="kategori">
                                    <option value="" {{ request('kategori') == '' ? 'selected' : '' }}>Semua</option>
                                    <option value="makanan" {{ request('kategori') == 'makanan' ? 'selected' : '' }}>Makanan
                                    </option>
                                    <option value="aksesoris" {{ request('kategori') == 'aksesoris' ? 'selected' : '' }}>
                                        Aksesoris</option>
                                    <option value="peralatan" {{ request('kategori') == 'peralatan' ? 'selected' : '' }}>
                                        Peralatan</option>
                                    <option value="obat-obatan"
                                        {{ request('kategori') == 'obat-obatan' ? 'selected' : '' }}>
                                        Obat-obatan</option>
                                </select>
                                <button type="submit" class="btn btn-primary p-2 mx-2" style="font-size: 18px">Filter</button>
                            </div>
                        </form>
                        <div class="card-body">
                            <div>
                                <table class="table-bordered table-md table">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama Customer</th>
                                        <th class="text-center">Telepon</th>
                                        <th class="text-center">Nama Produk</th>
                                        <th class="text-center">Jumlah Pembelian</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Metode Pembayaran</th>
                                        <th class="text-center">No Rekening</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    @if ($groupedOrders->isNotEmpty())
                                        @foreach ($groupedOrders as $idOrders => $orderGroup)
                                            @php
                                                $details = $orderGroup->first()->detail;
                                                $rowspan = $details->count();
                                                $totalHarga = $details->sum(
                                                    fn($item) => $item->jumlah_pembelian * $item->harga,
                                                );
                                            @endphp
                                            @foreach ($details as $index => $detail)
                                                <tr>
                                                    @if ($index === 0)
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">{{ $loop->parent->iteration }}
                                                        </td>
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            {{ $orderGroup->first()->user->name ?? ($orderGroup->first()->nama ?? '-') }}
                                                        </td>
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            {{ $orderGroup->first()->telepon ?? ($orderGroup->first()->user->phone ?? '-') }}
                                                        </td>
                                                    @endif
                                                    <td class="text-center" style="align-content: center;">
                                                        {{ $detail->product->nama_produk ?? '-' }}</td>
                                                    <td class="text-center" style="align-content: center;">
                                                        {{ $detail->jumlah_pembelian }}</td>
                                                    <td class="text-center" style="align-content: center;">Rp.
                                                        {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                                    @if ($index === 0)
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            Rp. {{ number_format($totalHarga, 0, ',', '.') }}
                                                        </td>
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            {{ $orderGroup->first()->co->atm ?? '-' }}
                                                        </td>
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            {{ $orderGroup->first()->co->no_rekening ?? '-' }}
                                                        </td>
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            @if ($orderGroup->first()->status_pesanan == 'proses')
                                                                <p class="badge badge-secondary">Proses</p>
                                                            @elseif($orderGroup->first()->status_pesanan == 'ditolak')
                                                                <p class="badge badge-danger">Pesanan ditolak</p>
                                                            @elseif($orderGroup->first()->status_pesanan == 'lunas')
                                                                <p class="badge badge-success">Lunas</p>
                                                            @endif
                                                        </td>
                                                        <td class="text-center" style="align-content: center;"
                                                            rowspan="{{ $rowspan }}">
                                                            @if ($orderGroup->first()->status_pesanan == 'proses')
                                                                <form
                                                                    action="/transaksi/{{ $orderGroup->first()->id_orders }}"
                                                                    method="post" class="d-inline">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <input type="hidden" name="status_pesanan"
                                                                        value="lunas">
                                                                    <button type="submit"
                                                                        class="badge badge-success">Pesanan Lunas</button>
                                                                </form>
                                                                <form
                                                                    action="/transaksi/{{ $orderGroup->first()->id_orders }}"
                                                                    method="post" class="d-inline">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <input type="hidden" name="status_pesanan"
                                                                        value="ditolak">
                                                                    <button type="submit" class="badge badge-danger">Tolak
                                                                        Pesanan</button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-center">Data kosong...</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
