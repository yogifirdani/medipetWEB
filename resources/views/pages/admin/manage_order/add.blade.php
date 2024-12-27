@extends('layouts.app')

@section('title', 'Tambah Pesanan')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Pesanan</h1>
            </div>

            <div class="section-body mt-5">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <form action="{{ route('transaksi.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="nama">Nama Customer</label>
                                            <input type="text" class="form-control" id="nama" name="nama"
                                                placeholder="Nama customer" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="phone">No Telepon</label>
                                            <input type="text" class="form-control" id="phone" name="telepon"
                                                placeholder="No Telepon" required>
                                        </div>
                                    </div>
                                </div>
                                <div id="product-container">
                                    <div class="row product-item">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label for="id_product">Pilih Produk</label>
                                                <select class="form-control id_product" id="id_product" name="id_product[]"
                                                    required>
                                                    <option value="">- Pilih Produk -</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->nama_produk }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label for="jumlah_pembelian">Jumlah Pembelian</label>
                                                <input type="number" class="form-control jumlah_pembelian"
                                                    id="jumlah_pembelian" name="jumlah_pembelian[]" min="1"
                                                    placeholder="Jumlah" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mb-3">
                                                <label for="harga">Harga</label>
                                                <input type="text" class="form-control harga" id="harga"
                                                    name="harga" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-3 align-self-center">
                                            <button type="button" class="btn btn-danger remove-product">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" id="add-product">Tambah Produk</button>
                                <div class="col-md-9 px-1 mt-3">
                                    <div class="form-group mb-3">
                                        <label for="total_harga">Total Harga</label>
                                        <input type="text" class="form-control" id="total_harga" name="total_harga"
                                            placeholder="Total" readonly>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6 px-1">
                                        <div class="form-group mb-3 col-12 col-md-5">
                                            <label for="atm">Metode Pembayaran</label>
                                            <select class="form-control @error('atm') is-invalid @enderror" id="atm"
                                                name="atm" required>
                                                <option value="">- none -</option>
                                                <option value="tunai">Tunai</option>
                                                <option value="bri">BRI</option>
                                                <option value="bca">BCA</option>
                                                <option value="bni">BNI</option>
                                                <option value="mandiri">Mandiri</option>
                                            </select>
                                            @error('atm')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group mb-3" id="no_rekening_group" style="display: none;">
                                            <label for="no_rekening">Nomor Rekening</label>
                                            <input type="text"
                                                class="form-control @error('no_rekening') is-invalid @enderror"
                                                id="no_rekening" name="no_rekening" placeholder="Masukkan Nomor Rekening">
                                            @error('no_rekening')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <center><button type="submit" class="btn btn-primary">Simpan</button></center>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#add-product').click(function() {
                const productTemplate = `
            <div class="row product-item mt-2">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <select class="form-control id_product" name="id_product[]" required>
                            <option value="">- Pilih Produk -</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="number" class="form-control jumlah_pembelian"
                        name="jumlah_pembelian[]" min="1" placeholder="Jumlah" required>
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control harga" readonly>
                </div>
                <div class="col-md-2 mb-3 align-self-center">
                    <button type="button" class="btn btn-danger remove-product">Hapus</button>
                </div>
            </div>`;
                $('#product-container').append(productTemplate);
                updateProductOptions();
            });

            $(document).on('change', '.id_product', function() {
                const productId = $(this).val();
                const currentRow = $(this).closest('.product-item');
                if (productId) {
                    $.ajax({
                        url: '/get-product-price/' + productId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            currentRow.find('.harga').val(data.harga.toLocaleString('id-ID'));
                            updateTotal();
                            updateProductOptions();
                        }
                    });
                }
            });

            $(document).on('click', '.remove-product', function() {
                $(this).closest('.product-item').remove();
                updateTotal();
                updateProductOptions();
            });

            function updateTotal() {
                let totalHarga = 0;

                $('.product-item').each(function() {
                    const jumlah = parseInt($(this).find('.jumlah_pembelian').val());
                    const harga = parseFloat($(this).find('.harga').val().replace(/\./g, ''));
                    if (!isNaN(jumlah) && !isNaN(harga)) {
                        totalHarga += jumlah * harga;
                    }
                });

                $('#total_harga').val(totalHarga.toLocaleString('id-ID'));
            }

            function updateProductOptions() {
                const selectedProducts = [];
                $('.id_product').each(function() {
                    const val = $(this).val();
                    if (val) {
                        selectedProducts.push(val);
                    }
                });

                $('.id_product').each(function() {
                    const currentValue = $(this).val();
                    $(this).find('option').each(function() {
                        if (selectedProducts.includes($(this).val()) && $(this).val() !==
                            currentValue) {
                            $(this).hide();
                        } else {
                            $(this).show();
                        }
                    });
                });
            }

            $('#atm').change(function() {
                const paymentMethod = $(this).val();
                if (['bri', 'bca', 'bni', 'mandiri'].includes(paymentMethod)) {
                    $('#no_rekening_group').show();
                } else {
                    $('#no_rekening_group').hide();
                }
            });

            $('#atm').trigger('change');
        });
    </script>
@endpush
