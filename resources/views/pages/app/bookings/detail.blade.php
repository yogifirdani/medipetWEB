@extends('layouts.app-cust')

@section('title', 'Detail Pemesanan')

@push('style')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
    }
    .main-content {
        padding: 20px;
    }
    .section-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .receipt-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 0 auto;
        max-width: 600px;
    }
    .receipt-header {
        text-align: center;
        margin-bottom: 20px;
    }
    .receipt-header h1 {
        font-size: 24px;
        margin: 0;
    }
    .receipt-header p {
        font-size: 16px;
        margin: 5px 0;
    }
    .receipt-section {
        margin-bottom: 20px;
    }
    .receipt-section h4 {
        border-bottom: 1px solid #ccc;
        padding-bottom: 5px;
        margin-bottom: 10px;
        font-size: 18px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        font-weight: bold;
    }
    .form-control {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 10px;
        width: 100%;
        box-sizing: border-box;
        background-color: #f9f9f9;
    }
    .form-control[readonly] {
        background-color: #e9ecef;
    }
    .thank-you-message {
        text-align: center;
        margin-top: 30px;
    }
    .thank-you-message h3 {
        margin: 0;
        font-size: 20px;
    }
    .button-container {
        text-align: center;
        margin-top: 20px;
    }
    .btn-back, .btn-print {
        display: inline-block;
        padding: 10px 20px;
        margin: 5px;
        border-radius: 4px;
        text-decoration: none;
        color: #fff;
        background-color: #007bff;
        transition: background-color 0.3s;
    }
    .btn-back:hover, .btn-print:hover {
        background-color: #0056b3;
    }
    .invoice-details {
        margin-top: 20px;
        border-collapse: collapse;
        width: 100%;
    }
    .invoice-details th, .invoice-details td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }
    .invoice-details th {
        background-color: #f2f2f2;
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
                <table class="invoice-details">
                    <tr>
                        <th>Nama Hewan</th>
                        <td>{{ $booking->pet_name }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Hewan</th>
                        <td>{{ $booking->pet_type }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Layanan</th>
                        <td>{{ $booking->booking_date }}</td>
                    </tr>
                    @if ($booking->take_date)
                    <tr>
                        <th>Tanggal Selesai</th>
                        <td>{{ $booking->take_date }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Jam Layanan</th>
                        <td>{{ $booking->start_time }}</td>
                    </tr>
                    @if ($booking->notes)
                    <tr>
                        <th>Catatan</th>
                        <td>{{ $booking->notes }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Total Harga</th>
                        <td>{{ $booking->total_price }}</td>
                    </tr>
                </table>
            </div>
            <div class="thank-you-message">
                <h3>Terima Kasih telah memesan layanan kami!</h3>
                <p>Kami menghargai kepercayaan Anda dan berharap dapat memberikan layanan terbaik untuk hewan peliharaan Anda.</p>
            </div>
            <div class="button-container">
                <a href="{{ url('/customer') }}" class="btn-back">Kembali ke Dashboard</a>
                <a href="{{ route('print.receipt', $booking->id) }}" class="btn-print">Print Kwitansi</a>
            </div>
        </div>
    </section>
</div>
@endsection
