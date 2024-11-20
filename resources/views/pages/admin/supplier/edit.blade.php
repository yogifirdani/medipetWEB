@extends('layouts.app')

@section('title', 'Edit Supplier')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Supplier</h1>
            </div>

            <div class="section-body mt-5">
                <div class="card">
                    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Supplier</label>
                                <input type="text" class="form-control" name="nama_supplier" value="{{ $supplier->nama_supplier }}" required>
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" name="alamat" value="{{ $supplier->alamat }}" required>
                            </div>

                            <div class="form-group">
                                <label>Kontak</label>
                                <input type="text" class="form-control" name="kontak" value="{{ $supplier->kontak }}" required>
                            </div>

                            <div class="form-group">
                                <label>ATM</label>
                                <input type="text" class="form-control" name="atm" value="{{ $supplier->atm }}" required>
                            </div>

                            <div class="form-group">
                                <label>No Rekening</label>
                                <input type="text" class="form-control" name="norek" value="{{ $supplier->norek }}" required>
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
