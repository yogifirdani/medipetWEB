@extends('layouts.app')

@section('title', 'Tambah Supplier')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Supplier</h1>
            </div>

            <div class="section-body mt-5">
                <div class="card">
                    <form action="{{ route('suppliers.store') }}" method="POST">
                        @csrf

                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Supplier</label>
                                <input type="text" class="form-control" name="nama_supplier" placeholder="Nama Supplier" required>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="alamat" placeholder="Alamat" required>
                            </div>

                            <div class="form-group">
                                <label>Kontak</label>
                                <input type="text" class="form-control" name="kontak" placeholder="Kontak" required>
                            </div>

                            <div class="form-group">
                                <label>ATM</label>
                                <input type="text" class="form-control" name="atm" placeholder="ATM" required>
                            </div>

                            <div class="form-group">
                                <label>No Rekening</label>
                                <input type="text" class="form-control" name="norek" placeholder="No Rekening" required>
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
    <!-- JS Libraries -->
    @section('js')
    @endsection
@endpush
