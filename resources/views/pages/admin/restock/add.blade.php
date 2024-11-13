@extends('layouts.app')

@section('title', 'Tambah Restock')

@push('style')
    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Pembelian</h1>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Pembelian</h4>
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

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('restocks.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="id_product">Pilih Produk</label>
                                <select name="id_product" id="id_product" class="form-control select2" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ old('id_product') == $product->id ? 'selected' : '' }}>
                                            {{ $product->nama_produk }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="quantity">Kuantitas</label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="{{ old('quantity') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="harga_satuan">Harga Satuan</label>
                                <input type="number" name="harga_satuan" id="harga_satuan" class="form-control" value="{{ old('harga_satuan') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="total_harga">Total Harga</label>
                                <input type="number" name="total_harga" id="total_harga" class="form-control" value="{{ old('total_harga') }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" class="form-control" value="{{ old('tanggal_pembelian') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="supplier">Supplier</label>
                                <input type="text" name="supplier" id="supplier" class="form-control" value="{{ old('supplier') }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('restocks.index') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    placeholder: '-- Pilih Produk --',
                    allowClear: true
                });

                document.getElementById('quantity').addEventListener('input', calculateTotal);
                document.getElementById('harga_satuan').addEventListener('input', calculateTotal);

                function calculateTotal() {
                    var quantity = document.getElementById('quantity').value;
                    var harga_satuan = document.getElementById('harga_satuan').value;
                    var total_harga = quantity * harga_satuan;

                    document.getElementById('total_harga').value = total_harga || 0;
                }
            });
        </script>
    @endpush
@endsection
