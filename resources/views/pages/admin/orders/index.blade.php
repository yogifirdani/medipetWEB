@extends('layouts.app')

@section('title', 'Daftar Booking')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Jadwal Layanan</h1>
        </div>

        <div class="section-body">
            <div class="col-12 col-md-12 col-lg-12">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ url('/categories') }}" class="btn btn-primary mt-5">
                    <h5>Kelola Kategori</h5>
                </a>
                <a href="{{ route('orders.create') }}" class="btn btn-primary mt-5">
                    <h5>Tambah Pesanan</h5>
                </a>

                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Daftar Pesanan</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table-bordered table-md table">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Nama Customer</th>
                                        <th>Nama Hewan</th>
                                        <th>Jenis Hewan</th>
                                        <th>Layanan</th>
                                        <th>Tanggal Mulai</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Notes</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->pet_name }}</td>
                                            <td>{{ $order->pet_type }}</td>
                                            <td>
                                                @if ($order->category)
                                                    {{ $order->category->service_category }}
                                                @else
                                                    Category not found
                                                @endif
                                            </td>
                                            <td>{{ $order->booking_date }}</td>
                                            <td>{{ $order->take_date }}</td>
                                            <td>{{ $order->notes }}</td>
                                            <td>{{ $order->total_price }}</td>
                                            <td>{{ $order->status ?? 'Menunggu diproses' }}</td>
                                            <td>
                                                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning">Edit</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
