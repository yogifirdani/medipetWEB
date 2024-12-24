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
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Nomor Telepon</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="service_type">Jenis Layanan</label>
                                            <select id="service_type" name="service_type" class="form-control" required>
                                                <option value="">Pilih</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" data-price="{{ $category->price }}"
                                                        data-pet-category="{{ $category->pet_category }}"
                                                        data-take-status="{{ $category->take_status }}">
                                                        {{ $category->service_category }} - {{ $category->pet_category }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pet_name">Nama Hewan</label>
                                            <input type="text" class="form-control" id="pet_name" name="pet_name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pet_type">Jenis Hewan</label>
                                            <input type="text" id="pet_type" name="pet_type" class="form-control"
                                                readonly required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="booking_date">Tanggal Mulai Layanan</label>
                                            <input type="date" class="form-control" id="booking_date" name="booking_date"
                                                required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" id="take-date-field" style="display: none;">
                                            <label for="take_date">Tanggal Selesai Layanan</label>
                                            <input type="date" class="form-control" id="take_date" name="take_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="start_time">Jam Layanan</label>
                                            <select id="start_time" name="start_time" class="form-control" required>
                                                <option value="">Pilih</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="total_price">Harga Layanan</label>
                                            <input type="text" class="form-control" id="total_price" name="total_price"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="status" value="Menunggu diproses">
                                <div class="row mb-3">
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
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var serviceTypeElement = document.getElementById('service_type');
            var startTimeElement = document.getElementById('start_time');
            var totalPriceElement = document.getElementById('total_price');
            var petTypeElement = document.getElementById('pet_type');
            var bookingDateElement = document.getElementById('booking_date');
            var takeDateElement = document.getElementById('take_date');
            var takeDateField = document.getElementById('take-date-field');

            serviceTypeElement.addEventListener('change', function() {
                var selectedCategoryId = this.value;

                if (selectedCategoryId) {
                    // Ambil service time sesuai kategori
                    fetch(`/getServiceTime/${selectedCategoryId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                // Kosongkan opsi jam layanan
                                startTimeElement.innerHTML =
                                    '<option value="">Pilih Jam Layanan</option>';
                                data.serviceTime.forEach(function(time) {
                                    var option = document.createElement('option');
                                    option.value = time;
                                    option.textContent = time;
                                    startTimeElement.appendChild(option);
                                });
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => console.error('Error:', error));

                    // Update harga dan jenis hewan
                    var selectedOption = this.options[this.selectedIndex];
                    var price = selectedOption.getAttribute('data-price');
                    var petCategory = selectedOption.getAttribute('data-pet-category');
                    var takeStatus = selectedOption.getAttribute('data-take-status');

                    totalPriceElement.value = 'Rp. ' + new Intl.NumberFormat('id-ID').format(price);
                    petTypeElement.value = petCategory;

                    // Tampilkan atau sembunyikan kolom "Tanggal Selesai Layanan"
                    if (takeStatus === 'NO') {
                        takeDateField.style.display = 'block';
                        takeDateElement.setAttribute('required', 'required');
                    } else {
                        takeDateField.style.display = 'none';
                        takeDateElement.removeAttribute('required');
                    }
                }
            });


            function calculateTotalPrice() {
                var selectedServiceOption = serviceTypeElement.options[serviceTypeElement.selectedIndex];
                var pricePerDay = parseFloat(selectedServiceOption.getAttribute('data-price')) || 0;
                var bookingDate = bookingDateElement.value;
                var takeDate = takeDateElement.value;

                console.log("Price per day:", pricePerDay);
                console.log("Booking Date:", bookingDate);
                console.log("Take Date:", takeDate);

                if (pricePerDay && bookingDate) {
                    var startDate = new Date(bookingDate);
                    var endDate = takeDate ? new Date(takeDate) : startDate;
                    var daysDifference = (endDate - startDate) / (1000 * 60 * 60 * 24) + 1; // Minimum 1 hari

                    console.log("Days difference:", daysDifference);

                    if (daysDifference > 0) {
                        var totalPrice = pricePerDay * daysDifference;
                        totalPriceElement.value = 'Rp. ' + new Intl.NumberFormat('id-ID').format(totalPrice);
                    } else {
                        totalPriceElement.value = '';
                    }
                } else {
                    totalPriceElement.value = '';
                }
            }


            bookingDateElement.addEventListener('change', calculateTotalPrice);
            takeDateElement.addEventListener('change', calculateTotalPrice);
        });
    </script>
@endsection
