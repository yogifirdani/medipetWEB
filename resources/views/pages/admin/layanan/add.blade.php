@extends('layouts.app')

@section('title', 'Nambah Item')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Nambah Layanan</h1>
            </div>

            <div class="section-body mt-5">
                <div class="card ">
                    <form action={{ 'layanans' }} method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Gambar Produk</label>
                                    <input type="file" accept="image/*" class="form-control" name="image">
                                </div>
                                <div class="form-group">
                                    <label>Nama Layanan</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nama">
                                </div>
                                <div class="form-group">
                                    <label>Category Layanan</label>
                                    <select class="form-select" name="category" aria-label="Default select example">
                                        <option selected disabled>Open this select menu</option>
                                        <option value="grooming">Grooming</option>
                                        <option value="vaksin">Vaksin</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Stok</label>
                                    <input type="text" class="form-control" name="stok" placeholder="Stok">
                                </div>
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="text" class="form-control" name="price" placeholder="Harga ">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <input type="text" class="form-control" name="deskripsi" placeholder="Deskripsi ">
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
