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
                <div class="card ">
                    <form action={{ route('transaksi.store') }} method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="id_product">Nama Produk</label>
                                            <select class="form-control" id="id_product" name="id_product" required>
                                                <option value="">Pilih Produk</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->nama_produk }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="total_harga">Total Harga</label>
                                            <input type="text" class="form-control" id="total_harga" name="total_harga"
                                                placeholder="Total" readonly>
                                        </div>
                                        <div class="form-group mb-3 col-12 col-md-5">
                                            <label for="atm">Metode Pembayaran</label>
                                            <br>
                                            <select class="form-control" id="atm" name="atm" required>
                                                <option value="">- none -</option>
                                                <option value="tunai">Tunai</option>
                                                <option value="bri">BRI</option>
                                                <option value="bca">BCA</option>
                                                <option value="bni">BNI</option>
                                                <option value="mandiri">Mandiri</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="jumlah_pembelian">Jumlah Pembelian</label>
                                            <input type="text" class="form-control" id="jumlah_pembelian"
                                                name="jumlah_pembelian" placeholder="Jumlah pembelian" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="harga">Harga</label>
                                            <input type="text" class="form-control" id="harga" name="harga"
                                                placeholder="Harga" readonly>
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
            $('#id_product').change(function() {
                var productId = $(this).val();
                if (productId) {
                    $.ajax({
                        url: '/get-product-price/' + productId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            var harga = parseInt(data.harga);
                            $('#harga').val(harga.toLocaleString('id-ID'));
                            updateTotal();
                        }
                    });
                } else {
                    $('#harga').val('');
                    updateTotal();
                }
            });

            $('#jumlah_pembelian').on('input', function() {
                updateTotal();
            });

            function updateTotal() {
                var harga = parseFloat($('#harga').val().replace(/\./g, ''));
                var jumlah = parseInt($('#jumlah_pembelian').val());

                if (!isNaN(harga) && !isNaN(jumlah)) {
                    var total = harga * jumlah;
                    $('#total_harga').val(total.toLocaleString('id-ID'));
                } else {
                    $('#total_harga').val('');
                }
            }
        });
    </script>
@endpush
