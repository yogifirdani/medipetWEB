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
                        <form method="GET" action="/transaksi" class="px-4 mb-3">
                            <label for="month">Bulan:</label>
                            <select class="form-select" aria-label="Default select example" name="month" id="month">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>

                            <label for="year">Tahun:</label>
                            <select class="form-select" aria-label="Default select example" name="year" id="year">
                                @for ($i = date('Y'); $i >= 2000; $i--)
                                    <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                        {{ $i }}</option>
                                @endfor
                            </select>

                            <label for="category">Kategori:</label>
                            <select class="form-select" aria-label="Default select example" name="category" id="category">
                                <option value="" {{ request('category') == '' ? 'selected' : '' }}>Semua</option>
                                <option value="makanan" {{ request('category') == 'makanan' ? 'selected' : '' }}>Makanan
                                </option>
                                <option value="asesoris" {{ request('category') == 'asesoris' ? 'selected' : '' }}>Asesoris
                                </option>
                                <option value="peralatan" {{ request('category') == 'peralatan' ? 'selected' : '' }}>
                                    Peralatan</option>
                                <option value="obat-obatan" {{ request('category') == 'obat-obatan' ? 'selected' : '' }}>
                                    Obat-obatan</option>
                            </select>
                            <button type="submit" class="btn btn-primary p-1" style="font-size: 18px">Filter</button>
                        </form>
                        <div class="card-body">
                            <div>
                                <table class="table-bordered table-md table">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Pesanan</th>
                                        <th class="text-center">Alamat</th>
                                        <th class="text-center">Jumlah Pembelian</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Metode Pembayaran</th>
                                        <th class="text-center">No Rekening</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                    @if (count($orders) > 0)
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $order->user->name ?? '-' }}</td>
                                                <td class="text-center">{{ $order->product->nama_produk }}</td>
                                                <td class="text-center">{{ $order->user->address?? '-'  }}</td>
                                                <td class="text-center">{{ $order->jumlah_pembelian }}</td>
                                                <td class="text-center">{{ $order->product->harga }}</td>
                                                <td class="text-center">
                                                    {{ $order->jumlah_pembelian * $order->product->harga }}</td>
                                                <td class="text-center">{{ $order->co->atm ?? '-' }}</td>
                                                <td class="text-center">{{ $order->co->no_rekening ?? '-' }}</td>
                                                <td class="text-center">
                                                    @if ($order->status_pesanan == 'proses')
                                                        <p class="badge badge-secondary">Proses</p>
                                                    @elseif($order->status_pesanan == 'ditolak')
                                                        <p class="badge badge-danger">Pesanan ditolak</p>
                                                    {{-- @elseif($order->status_pesanan == 'dikirim')
                                                        <p class="badge badge-info">Dikirim</p> --}}
                                                    @elseif($order->status_pesanan == 'lunas')
                                                        <p class="badge badge-success">Lunas</p>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($order->status_pesanan == 'proses')
                                                        <form action="/transaksi/{{ $order->id_orders }}" method="post"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="status_pesanan" value="lunas">
                                                            <button type="submit" class="badge badge-success">Pesanan
                                                                Lunas</button>
                                                        </form>
                                                        <form action="/transaksi/{{ $order->id_orders }}" method="post"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="status_pesanan" value="ditolak">
                                                            <button type="submit" class="badge badge-danger">Tolak
                                                                Pesanan</button>
                                                        </form>
                                                        {{-- <form action="/transaksi/{{ $order->id_orders }}" method="post"
                                                            class="d-inline">
                                                            @csrf
                                                            @method('POST')
                                                            <input type="hidden" name="status_pesanan" value="dikirim">
                                                            <button type="submit" class="badge badge-info">Dikirim</button>
                                                        </form> --}}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="9" class="text-center">Data kosong...</td>
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
