@extends('layouts.app-cust')

@section('title', 'Checkout')

@push('style')
    <style>
        .card {
            max-width: 950px;
            margin: auto;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-breadcrumb" style="height: 32px;">
                </div>
            </div>
            <form id="checkoutForm" method="post" action="{{ route('cart.checkout') }}" class="card rounded-4 mt-6">
                @csrf
                <input type="hidden" name="orders" value="{{ json_encode($selectedCart) }}">
                <div class="card rounded-4 mt-6">
                    <div class="card-body p-4">
                        <table class="table-bordered table-md table">
                            <div class="col-12">
                                <h2 class="text-left mb-4">Pemesanan</h2>
                                <th class="col-md-3">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <span><i class="fa-solid fa-location-dot px-2"></i> Alamat Pengiriman</span>
                                            <div class="mt-2 px-5"><a> {{ Auth::user()->name }}</a></div>
                                            <div class="px-5"><a> {{ Auth::user()->email }}</a></div>
                                            <div class="px-5"><a> {{ Auth::user()->phone }}</a></div>
                                            <div class="px-5"><a> {{ Auth::user()->address }}</a></div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-center justify-content-center text-right">
                                            <a href="/profile/edit" class="text-blue-500">Edit</a>
                                        </div>
                                    </div>
                                </th>
                            </div>
                        </table>

                        <div class="row">
                            @foreach ($selectedCart as $item)
                                <div class="row p-4">
                                    <div class="col-sm-3 hidden-xs">
                                        <img src="{{ asset('product/' . $item['image']) }}" class="card-img-top">
                                    </div>
                                    <div class="col-md-3 col-lg-3 col-xl-3">
                                        <span class="px-3">{{ $item['nama_produk'] }}</span>
                                        <div class="px-3">{{ $item['quantity'] }} x</div>
                                        <div class="invoice-detail-value mt-2 px-3">Rp. {{ $item['harga'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row">
                            <div class="mx-3 col-md-4 mt-4">
                                <strong class="mx-3">Pembayaran</strong>
                                <div class="col-8">
                                    <select type="text" class="form-control mt-2" aria-label="Default select example"
                                        id="atm" name="atm" aria-label="Default select example" required>
                                        <option selected>-- none --</option>
                                        <option value="BRI">BRI</option>
                                        <option value="BCA">BCA</option>
                                        <option value="BNI">BNI</option>
                                        <option value="MANDIRI">Mandiri</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 mt-4">
                                <div class="form-group">
                                    <strong for="no_rekening">No.Rekening</strong>
                                    <input type="text"
                                        class="form-control mt-2 @error('no_rekening') is-invalid @enderror"
                                        id="no_rekening" name="no_rekening">
                                    @error('no_rekening')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex flex-column align-items-end">
                            <strong class="text-muted mt-2" style="font-size: 16px;">Total Pembayaran</strong>
                            <h4 class="mt-2" style="font-size: 28px; color: #5c5c5c;">Rp.
                                {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                        </div>
                        <div class="text-md-right mt-3">
                            <div class="float-lg-right mb-lg-0">
                                <a class="btn btn-danger btn-icon icon-left" href="/cart">Batal</a>
                                <button type="submit" class="btn btn-primary" id="checkoutButton">Beli Sekarang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#checkoutForm').on('submit', function(e) {
                e.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = "{{ route('success') }}";
                        } else {
                            alert('Terjadi kesalahan, coba lagi. ' + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        alert('Terjadi kesalahan, coba lagi.');
                    }
                });
            });
        });
    </script>
@endpush
