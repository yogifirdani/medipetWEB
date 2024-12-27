@extends('layouts.app')

@section('title', 'Edit Restock')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Restock</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Components</a></div>
                    <div class="breadcrumb-item">Edit Pembelian</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Edit Restock</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('restocks.update', $restock->id_restock) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="id_product">Pilih Produk</label>
                                <select name="id_product" id="id_product" class="form-control select2" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ old('id_product', $restock->id_product) == $product->id ? 'selected' : '' }}>
                                            {{ $product->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Kuantitas</label>
                                <input type="number" name="quantity" id="quantity" class="form-control"
                                    value="{{ old('quantity', $restock->quantity) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="harga_satuan">Harga Satuan</label>
                                <input type="number" name="harga_satuan" id="harga_satuan" class="form-control"
                                    value="{{ old('harga_satuan', $restock->harga_satuan) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <input type="number" name="total_harga" id="total_harga" class="form-control"
                                    value="{{ old('total_harga', $restock->total_harga) }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="form-control"
                                    value="{{ old('tanggal_pembelian', $restock->tanggal_pembelian) }}" required>
                            </div>
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <input name="total_harga" id="supplier" class="form-control"
                                    value="{{ old('supplier', $restock->supplier) }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                            <a href="{{ route('restocks.index') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: '-- Pilih Produk --',
                allowClear: true
            });
        });

        // Otomatis menghitung total harga saat quantity atau harga_satuan diubah
        document.getElementById('quantity').addEventListener('input', calculateTotal);
        document.getElementById('harga_satuan').addEventListener('input', calculateTotal);

        function calculateTotal() {
            var quantity = document.getElementById('quantity').value;
            var harga_satuan = document.getElementById('harga_satuan').value;
            var total_harga = quantity * harga_satuan;

            document.getElementById('total_harga').value = total_harga || 0;
        }

        // Hitung total harga pada load halaman untuk menampilkan nilai yang benar
        calculateTotal();
    </script>
@endpush
