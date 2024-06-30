@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Kategori</h1>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Form Tambah Kategori</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="pet_category">Jenis Hewan</label>
                                <input type="text" class="form-control" id="pet_category" name="pet_category" required>
                            </div>
                            <div class="form-group">
                                <label for="service_category">Jenis Layanan</label>
                                <input type="text" class="form-control" id="service_category" name="service_category" required>
                            </div>
                            <div class="form-group">
                                <label for="service_time">Jam Layanan</label>
                                <div id="service-time">
                                    <div class="input-group mb-2">
                                        <input type="time" class="form-control" name="service_time[]" required>
                                        <button type="button" class="btn btn-danger btn-remove-time">Hapus</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success" id="add-time">Tambah Jam</button>
                            </div>
                            <div class="form-group">
                                <label for="price">Layanan Satu Hari</label>
                                <select id="take_status" name="take_status" class="form-control" required>
                                    <option value="">Pilih</option>
                                    <option value="NO">NO</option>
                                    <option value="YES">YES</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price">Harga</label>
                                <input type="number" class="form-control" id="price" name="price" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('add-time').addEventListener('click', function() {
            var newInput = document.createElement('div');
            newInput.classList.add('input-group', 'mb-2');
            newInput.innerHTML = '<input type="time" class="form-control" name="service_time[]" required>' +
                                 '<button type="button" class="btn btn-danger btn-remove-time">Hapus</button>';
            document.getElementById('service-time').appendChild(newInput);
        });

        document.getElementById('service-time').addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('btn-remove-time')) {
                e.target.parentElement.remove();
            }
        });
    });
</script>
@endsection
