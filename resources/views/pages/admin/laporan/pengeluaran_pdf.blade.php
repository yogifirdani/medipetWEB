//pemasukan_pdf.blade.php




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penjualan PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1, h4 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Data Penjualan</h1>
    <h4>Bulan: {{ date('F', mktime(0, 0, 0, $month, 1)) }} Tahun: {{ $year }}</h4>

    <h5>Total Pendapatan: {{ number_format($totalRevenue, 2, ',', '.') }}</h5>
    <h5>Total Pembelian: {{ $totalPurchases }}</h5>

    <h5>Data Penjualan Produk</h5>
    <table>
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Total Terjual</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productOrders as $order)
                <tr>
                    <td>{{ $order->product->nama_produk }}</td>
                    <td>{{ $order->total_quantity }}</td>
                    <td>{{ number_format($order->total_quantity * $order->product->harga, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            @foreach ($unsoldProducts as $product)
                <tr>
                    <td>{{ $product->nama_produk }}</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h5>Data Layanan</h5>
    <table>
        <thead>
            <tr>
                <th>Nama Layanan</th>
                <th>Total Dipesan</th>
                <th>Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($serviceBookings as $booking)
                <tr>
                    <td>{{ $booking->category->service_category }}</td>
                    <td>{{ $booking->total_bookings }}</td>
                    <td>{{ number_format($booking->total_bookings * $booking->category->price, 2, ',', '.') }}</td>
                </tr>
            @endforeach
            @foreach ($unsoldServices as $service)
                <tr>
                    <td>{{ $service->service_category }}</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($productOrders->isEmpty() && $serviceBookings->isEmpty())
        <p class="text-center">Tidak ada data penjualan untuk bulan dan tahun yang dipilih.</p>
    @endif
</body>
</html>
