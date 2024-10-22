@extends('layouts.app-cust')

@section('title', 'Pesanan Berhasil')

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
                <div class="card-body p-4 text-center">
                    {{-- @if(session('message')) --}}
                        {{-- <h2 class="text-success mb-4">{{ session('message') }}</h2> --}}
                        <h2 style="color: green">PESANAN BERHASIL!</h2> <br>
                        <h5>Silahkan Lakukan Pembayaran Ke Nomor rekening Berikut:</h5>
                        <h6>Nomor Rekening: <strong>1234567890</strong></h6>
                        {{-- <h6>Nomor Rekening: <strong>{{ session('RekAdmin') }}</strong></h6> --}}
                    {{-- @else
                        <h2 class="text-danger mb-4">Terjadi kesalahan.</h2>
                    @endif --}}
                    <a href="/catalogs" class="btn btn-primary" style="margin-right: 30px;">Lanjut Pembelian</a>
                    <a href="/history" class="btn btn-primary">Riwayat Pesanan</a>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
@endpush
