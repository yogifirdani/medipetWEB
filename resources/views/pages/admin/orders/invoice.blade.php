<!-- resources/views/invoices/invoice.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Kwitansi Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            background-color: #f4f4f4;
        }
        .invoice-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-header h1 {
            font-size: 24px;
            margin: 0;
        }
        .invoice-header p {
            font-size: 16px;
            margin: 5px 0;
        }
        h4 {
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-top: 20px;
            font-size: 18px;
        }
        .invoice-details {
            margin-bottom: 20px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f2f2f2;
        }
        .thank-you {
            margin-top: 30px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>Kwitansi Pemesanan</h1>
            <p>No. Pemesanan: #{{ $booking->id }}</p>
        </div>

        <div class="invoice-details">
            <h4>Informasi Pelanggan</h4>
            <p>Nama Lengkap: {{ $booking->name }}</p>
            <p>Nomor Telepon: {{ $booking->phone }}</p>
            <p>Email: {{ $booking->email }}</p>
        </div>

        <h4>Detail Layanan</h4>
        <table class="invoice-table">
            <tr>
                <th>Jenis Layanan</th>
                <td>{{ $booking->category ? $booking->category->service_category : 'N/A' }}</td>
            </tr>
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
            <tr>
                <th>Tanggal Selesai</th>
                @if ($booking->take_date)
                    <td>{{ $booking->take_date}}</td>
                @else
                <td> - </td>
                @endif
            </tr>
            <tr>
                <th>Jam Layanan</th>
                <td>{{ $booking->start_time }}</td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td>{{ 'Rp. ' . number_format($booking->total_price, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div class="thank-you">
            <p>Terima kasih telah memesan layanan kami!</p>
        </div>
    </div>
</body>
</html>
