@extends('layouts.app')

@section('title', 'Service Booking')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Pesanan</h1>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Detail Pesanan</h4>
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
                        <form action="{{ route('orders.update', $booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $booking->name }}" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Phone Number</label>
                                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $booking->phone }}" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $booking->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="service_type">Jenis Layanan</label>
                                        <input type="text" id="service_type" name="service_type" class="form-control" value="{{ $booking->service_type }}" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pet_name">Nama Hewan</label>
                                        <input type="text" class="form-control" id="pet_name" name="pet_name" value="{{ $booking->pet_name }}" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pet_type">Jenis Hewan</label>
                                        <input type="text" id="pet_type" name="pet_type" class="form-control" value="{{ $booking->pet_type }}" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="booking_date">Tanggal Mulai Layanan</label>
                                        <input type="date" class="form-control" id="booking_date" name="booking_date" value="{{ $booking->booking_date }}" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" id="take-date-field" style="display: none;">
                                        <label for="take_date">Tanggal Selesai Layanan</label>
                                        <input type="date" class="form-control" id="take_date" name="take_date" value="{{ $booking->take_date }}" readonly required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_time">Jam Layanan</label>
                                        <input id="start_time" name="start_time" class="form-control" value="{{ $booking->start_time }}" readonly required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total_price">Harga Layanan</label>
                                        <input type="text" class="form-control" id="total_price" name="total_price" value="{{ $booking->total_price }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status Pesanan</label>
                                        <select id="status" name="status" class="form-control" required>
                                            <option value="Menunggu diproses" {{ $booking->status == 'Menunggu diproses' ? 'selected' : '' }}>Menunggu diproses</option>
                                            <option value="Diproses" {{ $booking->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="Selesai" {{ $booking->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
