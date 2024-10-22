@extends('layouts.app-cust')

@section('title', 'Cart')

@push('style')
    {{-- CSS Libraries --}}
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Keranjang</h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            <div class="card rounded-3 mt-4">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table-bordered table-md table">
                            @if (session('cart'))
                                @foreach (session('cart') as $id => $details)
                                    <tr rowId="{{ $id }}">
                                        <th>
                                            <input type="checkbox" name="selected_items[]" value="{{ $id }}"
                                                data-price="{{ $details['harga'] * $details['quantity'] }}"
                                                class="item-checkbox">
                                        </th>
                                        <th data-th="Product">
                                            <div class="row">
                                                <div class="col-sm-3 hidden-xs">
                                                    <img src="{{ asset('product/' . $details['image']) }}"
                                                        class="card-img-top">
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                    <p class="nomargin" style="font-weight: bold; font-size: 150%;">
                                                        {{ $details['nama'] }}</p>
                                                    <p data-th="harga">Rp.{{ $details['harga'] }}</p>
                                                </div>
                                        <th>
                                            <div class="col-md-3 col-lg-6 col-xl d-flex">
                                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2"
                                                    onclick="updateQuantity(this, -1, {{ $details['harga'] }}, {{ $id }})">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input id="quantity-{{ $id }}" min="1" name="quantity"
                                                    value="{{ $details['quantity'] }}" type="number"
                                                    class="form-control form-control-sm" onchange="updateTotalPrice()" />
                                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-link px-2"
                                                    onclick="updateQuantity(this, 1, {{ $details['harga'] }}, {{ $id }})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </th>
                    </div>
                    </th>
                    <th class="action">
                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm"><i
                                    class="fa fa-trash"></i></button>
                        </form>
                    </th>
                    </tr>
                    @endforeach
                    @endif
                    </table>
                </div>
            </div>
    </div>
    <div class="card mb-5">
        <div class="card-body p-4">
            <div class="float-end">
                <p class="mb-0 me-5 d-flex justify-content-end align-items-center">
                    <span class="text-muted fw-normal mb-2 px-4" style="font-size: 115%">Total: </span>
                    <span class="fw-normal mb-2 px-2" id="totalPrice" style="font-size: 110%">Rp. 0</span>
                </p>
            </div>
            <div class="mt-3 d-flex justify-content-end">
                <form action="{{ route('pemesanan') }}" method="POST">
                    @csrf
                    <input type="hidden" name="selected_items" id="selectedItems">
                    <button type="submit" class="btn btn-primary btn-lg me-2">Pesan</button>
                </form>
            </div>
        </div>
    </div>
    </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            const totalPriceElement = document.getElementById('totalPrice');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotalPrice);
            });

            function updateTotalPrice() {
                let total = 0;
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const itemId = checkbox.value;
                        const itemQuantity = document.getElementById(`quantity-${itemId}`).value;
                        const itemPrice = parseFloat(checkbox.getAttribute('data-price')) / itemQuantity;
                        total += itemPrice * itemQuantity;
                    }
                });
                totalPriceElement.textContent = 'Rp. ' + total.toLocaleString('id-ID');
            }

            window.updateQuantity = function(element, delta, itemPrice, itemId) {
                const quantityInput = document.getElementById(`quantity-${itemId}`);
                let quantity = parseInt(quantityInput.value);
                quantity = Math.max(1, quantity + delta);
                quantityInput.value = quantity;

                const checkbox = document.querySelector(`input[name="selected_items[]"][value="${itemId}"]`);
                checkbox.setAttribute('data-price', itemPrice * quantity);

                updateTotalPrice();
            }

            const orderForm = document.querySelector('form[action="{{ route('pemesanan') }}"]');
            orderForm.addEventListener('submit', function(e) {
                const selectedItems = [];
                checkboxes.forEach(checkbox => {
                    if (checkbox.checked) {
                        const itemId = checkbox.value;
                        const itemQuantity = document.getElementById(`quantity-${itemId}`).value;
                        selectedItems.push({
                            id: itemId,
                            quantity: itemQuantity
                        });
                    }
                });
                console.log('Selected Items:', selectedItems); // Tambahkan ini untuk debugging
                document.getElementById('selectedItems').value = JSON.stringify(selectedItems);
            });


        });
    </script>
@endpush
