<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pembelian</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Pembelian</h1>
    <p>Tanggal cetak: {{ date('d-m-Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Nama Produk/Layanan</th>
                <th>Kuantitas</th>
                <th>Tanggal Transaksi</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $index = 1; @endphp
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{ $order->product->nama_produk }}</td>
                    <td>{{ $order->jumlah_pembelian }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>{{ $order->total_harga }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

