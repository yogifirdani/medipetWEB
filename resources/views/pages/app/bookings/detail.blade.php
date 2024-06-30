@extends('layouts.app-cust')

@section('title', 'Detail Pemesanan')

@push('style')
<style>
    .receipt-container {
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 10px;
        max-width: 800px;
        margin: 0 auto;
        font-family: Arial, sans-serif;
    }
    .receipt-header {
        text-align: center;
        margin-bottom: 30px;
    }
    .receipt-header h1 {
        font-size: 24px;
        margin: 0;
    }
    .receipt-header p {
        margin: 5px 0 0;
        font-size: 14px;
        color: #888;
    }
    .receipt-section {
        margin-bottom: 20px;
    }
    .receipt-section h4 {
        font-size: 18px;
        margin-bottom: 10px;
        color: #444;
        border-bottom: 2px solid #ddd;
        padding-bottom: 5px;
    }
    .receipt-section .form-group {
        margin-bottom: 10px;
    }
    .receipt-section label {
        font-weight: bold;
        color: #333;
    }
    .receipt-section .form-control {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        color: #333;
    }
    .total-price {
        margin-top: 20px;
        font-size: 20px;
        text-align: right;
        color: #d9534f;
    }
    .info-box {
        margin-top: 30px;
        padding: 15px;
        border: 1px dashed #007bff;
        background-color: #e9f7ff;
        color: #007bff;
        border-radius: 10px;
        font-size: 14px;
        text-align: center;
    }
    .button-container {
        text-align: center;
        margin-top: 20px;
    }
    .btn-back {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        color: #fff;
        text-decoration: none;
    }
    .btn-back:hover {
        background-color: #0056b3;
    }
</style>
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Detail Pemesanan</h1>
        </div>
        <div class="receipt-container">
            <div class="receipt-header">
                <h1>Kwitansi Pemesanan</h1>
                <p>No. Pemesanan: #{{ $booking->id }}</p>
            </div>
            <div class="receipt-section">
                <h4>Informasi Pelanggan</h4>
                <div class="form-group">
                    <label for="fullName">Nama Lengkap</label>
                    <input type="text" class="form-control" id="fullName" value="{{ $booking->name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon</label>
                    <input type="text" class="form-control" id="phone" value="{{ $booking->phone }}" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" value="{{ $booking->email }}" readonly>
                </div>
            </div>
            <div class="receipt-section">
                <h4>Detail Layanan</h4>
                <div class="form-group">
                    <label for="service_type">Jenis Layanan</label>
                    <input type="text" class="form-control" id="service_type" value="{{ $category->service_category }}" readonly>
                </div>
                <div class="form-group">
                    <label for="pet_name">Nama Hewan</label>
                    <input type="text" class="form-control" id="pet_name" value="{{ $booking->pet_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="pet_type">Jenis Hewan</label>
                    <input type="text" class="form-control" id="pet_type" value="{{ $booking->pet_type }}" readonly>
                </div>
            </div>
            <div class="receipt-section">
                <h4>Jadwal Layanan</h4>
                <div class="form-group">
                    <label for="booking_date">Tanggal Layanan</label>
                    <input type="text" class="form-control" id="booking_date" value="{{ $booking->booking_date }}" readonly>
                </div>
                @if ($booking->take_date)
                <div class="form-group">
                    <label for="take_date">Tanggal Selesai</label>
                    <input type="text" class="form-control" id="take_date" value="{{ $booking->take_date }}" readonly>
                </div>
                @endif
                <div class="form-group">
                    <label for="start_time">Jam Layanan</label>
                    <input type="text" class="form-control" id="start_time" value="{{ $booking->start_time }}" readonly>
                </div>
                @php
                    $estimatedEndTime = $category->take_status === 'NO'
                        ? $booking->start_time
                        : (new DateTime($booking->booking_date . ' ' . $booking->start_time))->modify('+3 hours')->format('H:i');
                @endphp
                <div class="form-group">
                    <label for="estimated_end_time">Estimasi Jam Selesai</label>
                    <input type="text" class="form-control" id="estimated_end_time" value="{{ $estimatedEndTime }}" readonly>
                </div>
                @if ($booking->notes)
                <div class="form-group">
                    <label for="notes">Catatan</label>
                    <input type="text" class="form-control" id="notes" value="{{ $booking->notes }}" readonly>
                </div>
                @endif
            </div>
            @if ($category->take_status !== 'NO')
            <div class="total-price">
                <strong>Total Harga: {{ 'Rp. ' . number_format(intval($category->price ?? 0), 0, ',', '.') }}</strong>
            </div>
            @endif
            <div class="info-box">
                @if ($category->take_status === 'YES')
                <p><strong>Mohon tunjukkan kwitansi ini kepada admin yang bertugas sebagai bukti pemesanan, dan untuk pembayaran akan dikalkulasikan setelah layanan Pet Hotel telah selesai. Terimakasih</strong></p>
                @else
                <p><strong>Mohon tunjukkan kwitansi ini kepada admin yang bertugas sebagai bukti pemesanan, dan bawalah uang sejumlah yang tertera di kwitansi ini untuk dibayarkan setelah layanan selesai dilakukan.</strong></p>
                @endif
            </div>
            <div class="button-container">
                <a href="{{ url('/customer') }}" class="btn-back">Kembali ke Dashboard</a>
            </div>
        </div>
    </section>
</div>
@endsection
