pdf.blade.php

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Keuangan</h1>
    <table>
        <thead>
            <tr>
                <th>ID Report</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
            <tr>
                <td>{{ $transaction->id }}</td>
                <td>{{ $transaction->date }}</td>
                <td>{{ $transaction->description }}</td>
                <td>{{ $transaction->category ? $transaction->category->name : 'N/A' }}</td>
                <td>{{ $transaction->income ? 'Rp ' . number_format($transaction->income, 0, ',', '.') : '-' }}</td>
                <td>{{ $transaction->expense ? 'Rp ' . number_format($transaction->expense, 0, ',', '.') : '-' }}</td>
                <td>Rp {{ number_format($transaction->balance, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data transaksi</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
