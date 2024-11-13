@extends('layouts.app')

@section('title', 'Laporan Keuangan')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Laporan Keuangan</h1>
        </div>

        <div class="section-body">
            <div class="col-12 col-md-12 col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Filter transaksi berdasarkan bulan --}}
                <form action="{{ route('report.index') }}" method="GET" class="mb-4">
                    <div class="form-group">
                        <label for="month">Pilih Bulan</label>
                        <select name="month" id="month" class="form-control">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1, 12) as $month)
                                <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>

                {{-- Print Button --}}
                <button onclick="printReport()" class="btn btn-secondary mb-4">Print</button>

                {{-- Tabel Transaksi --}}
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Laporan Keuangan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-bordered table-md table" id="reportTable">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@section('scripts')
<script>
    function printReport() {
        var printContents = document.getElementById('reportTable').outerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Reload the page to restore the original content
    }
</script>
@endsection

@endsection
