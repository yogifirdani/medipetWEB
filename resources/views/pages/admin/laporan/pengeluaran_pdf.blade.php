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
                <th>Tanggal</th>
                <th>Jenis Transaksi</th>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Supplier</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $index = 1; @endphp
            @foreach ($restocks as $restock)
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $restock->tanggal_pembelian }}</td>
                    <td>Restock</td>
                    <td>{{ $restock->product->nama_produk }}</td>
                    <td>{{ $restock->quantity }}</td>
                    <td>{{ $restock->harga_satuan }}</td>
                    <td>{{ $restock->supplier }}</td>
                    <td>{{ $restock->total_harga }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
