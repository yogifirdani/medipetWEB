@extends('layouts.app-cust')

@section('title', 'Service Booking')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Pesan Layanan</h1>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Tambah Pesanan</h4>
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
                        <form id="bookingForm" action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Nama Panjang</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Nomor Telepon</label>
                                        <input type="text" class="form-control" id="phone" name="phone" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_type">Jenis Layanan</label>
                                        <select id="service_type" name="service_type" class="form-control" required>
                                            <option value="">Pilih</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}"
                                                        data-price="{{ $category->price }}"
                                                        data-pet-category="{{ $category->pet_category }}"
                                                        data-take-status="{{ $category->take_status }}">
                                                    {{ $category->service_category }} - {{ $category->pet_category }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pet_name">Nama Hewan</label>
                                        <input type="text" class="form-control" id="pet_name" name="pet_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pet_type">Jenis Hewan</label>
                                        <input type="text" id="pet_type" name="pet_type" class="form-control" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="booking_date">Tanggal Mulai Layanan</label>
                                        <input type="date" class="form-control" id="booking_date" name="booking_date" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="take-date-field" style="display: none;">
                                        <label for="take_date">Tanggal Selesai Layanan</label>
                                        <input type="date" class="form-control" id="take_date" name="take_date">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_time">Jam Layanan</label>
                                        <select id="start_time" name="start_time" class="form-control" required>
                                            <option value="">Pilih</option>
                                            @foreach($serviceTime as $time)
                                                <option value="{{ $time }}">{{ $time }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_price">Harga Layanan</label>
                                        <input type="text" class="form-control" id="total_price" name="total_price" readonly>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status Pesanan</label>
                                        <select id="status" name="status" class="form-control" required>
                                            <option value="Menunggu diproses">Menunggu diproses</option>
                                            <option value="Diproses">Diproses</option>
                                            <option value="Selesai">Selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control" id="notes" name="notes"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Booking</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Harga Layanan</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach($categories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $category->service_category }} - {{ $category->pet_category }}
                                    <span>{{ 'Rp. ' . number_format($category->price, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var serviceTypeElement = document.getElementById('service_type');
        var petTypeElement = document.getElementById('pet_type');
        var totalPriceElement = document.getElementById('total_price');
        var bookingDateElement = document.getElementById('booking_date');
        var takeDateElement = document.getElementById('take_date');
        var takeDateField = document.getElementById('take-date-field');
        var bookingForm = document.getElementById('bookingForm');

        var categories = @json($categories);

        function updateServiceInfo() {
            var selectedServiceOption = serviceTypeElement.options[serviceTypeElement.selectedIndex];
            var price = selectedServiceOption.getAttribute('data-price');
            var takeStatus = selectedServiceOption.getAttribute('data-take-status');
            var petCategory = selectedServiceOption.getAttribute('data-pet-category');

            totalPriceElement.value = price ? 'Rp. ' + new Intl.NumberFormat('id-ID').format(price) : '';
            petTypeElement.value = petCategory || '';

            if (takeStatus === 'YES') {
                takeDateField.style.display = 'none';
                takeDateElement.value = bookingDateElement.value;
                takeDateElement.removeAttribute('required');
            } else {
                takeDateField.style.display = 'block';
                takeDateElement.setAttribute('required', 'required');
                takeDateElement.value = '';
            }
        }

        serviceTypeElement.addEventListener('change', updateServiceInfo);
        updateServiceInfo();

        bookingForm.addEventListener('submit', function (e) {
            var priceValue = totalPriceElement.value.replace(/[^0-9]/g, '');
            totalPriceElement.value = priceValue;

            if (takeDateField.style.display === 'none') {
                takeDateElement.removeAttribute('required');
            }

            if (takeDateElement.style.display !== 'none' && !takeDateElement.value) {
                takeDateElement.value = bookingDateElement.value;
            }
        });
    });
</script>
@endsection
