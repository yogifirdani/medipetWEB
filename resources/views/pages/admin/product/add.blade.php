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
                                    <input type="text" class="form-control" name="nama" placeholder="Nama">
                                </div>
                                <div class="form-group">
                                    <label>Jenis Hewan</label>
                                    <input type="text" class="form-control" name="jenis_hewan" placeholder="Jenis Hewan">
                                </div>
                                <div class="form-group">
                                    <label>Kategori Product</label>
                                    <input type="text" class="form-control" name="kategori" placeholder="Kategori">
                                </div>
                                <div class="form-group">
                                    <label>Merek</label>
                                    <input type="text" class="form-control" name="merek" placeholder="Merek">
                                </div>
                                <div class="form-group">
                                    <label>Berat</label>
                                    <input type="text" class="form-control" name="berat" placeholder="Berat">
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="text" class="form-control" name="stok" placeholder="Stok">
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control" name="harga" placeholder="Harga ">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control" name="deskripsi" placeholder="Deskripsi ">
                                </div>
                                <div class="form-group">
                                    <label>Tanggal Kadaluarsa</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control datepicker" name="kadaluarsa" />
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
