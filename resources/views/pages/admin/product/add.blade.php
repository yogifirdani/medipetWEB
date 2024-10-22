@extends('layouts.app')

@section('title', 'Nambah Item')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Nambah Item</h1>
            </div>

            <div class="section-body mt-5">
                <div class="card ">
                    <form action={{ url('/products') }} method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Gambar Produk</label>
                                    <input type="file" accept="image/*" class="form-control" name="image">
                                </div>
                                <div class="form-group">
                                    <label>Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" placeholder="Nama Produk">
                                </div>

                                <div class="row">
                                    <!-- Kolom Kiri -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="jenis_hewan">Jenis Hewan</label>
                                            <input type="text" class="form-control" id="jenis_hewan" name="jenis_hewan" placeholder="Jenis Hewan">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="merek">Merek</label>
                                            <input type="text" class="form-control" id="merek" name="merek" placeholder="Merek">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="stok">Stok</label>
                                            <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="deskripsi">Deskripsi</label>
                                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi">
                                        </div>
                                    </div>

                                    <!-- Kolom Kanan -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="kategori">Kategori Produk</label>
                                            <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Kategori">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="berat">Berat</label>
                                            <input type="text" class="form-control" id="berat" name="berat" placeholder="Berat">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="harga">Harga</label>
                                            <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="kadaluarsa">Tanggal Kadaluarsa</label>
                                            <div class="input-group">
                                                <input type="date" class="form-control" id="kadaluarsa" name="kadaluarsa">
                                            </div>
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
    <!-- JS Libraies -->
    @section('js')
        <script></script>
    @endsection
@endpush
