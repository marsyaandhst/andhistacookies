@extends('layouts.main')

@section('content')
    <div class="container mx-auto py-8" style="margin-top: 11%">
        <h1 class="text-2xl font-bold mb-4">Shopping Cart</h1>
        <table id="cartTable" class="w-full border-collapse">
            <thead>
                <tr>
                    <th class="px-4 py-2 bg-gray-100 border-b-2 border-gray-300">Product Photo</th>
                    <th class="px-4 py-2 bg-gray-100 border-b-2 border-gray-300">Product Name</th>
                    <th class="px-4 py-2 bg-gray-100 border-b-2 border-gray-300">Price</th>
                    <th class="px-4 py-2 bg-gray-100 border-b-2 border-gray-300">Quantity</th>
                    <th class="px-4 py-2 bg-gray-100 border-b-2 border-gray-300">Total x Quantity</th>
                    <th class="px-4 py-2 bg-gray-100 border-b-2 border-gray-300">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $cartItem)
                    <tr>
                        <td class="text-center"><img src="{{ asset('fotokue/' . $cartItem->product->photo) }}"
                                alt="{{ $cartItem->product->namakue }}" width="150"></td>
                        <td class="px-4 py-2">{{ $cartItem->product->namakue }}</td>
                        <td class="px-4 py-2 price">Rp {{ number_format($cartItem->product->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <input type="number" min="1" value="{{ $cartItem->quantity }}"
                                data-cartitemid="{{ $cartItem->id }}" data-productid="{{ $cartItem->product->id }}"
                                class="w-20 py-2 px-3 border border-gray-300 rounded quantity-input">
                        </td>
                        <td class="px-4 py-2 total-price"
                            data-price="{{ $cartItem->product->harga * $cartItem->quantity }}">Rp
                            {{ number_format($cartItem->product->harga * $cartItem->quantity, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <button onclick="removeCartItem({{ $cartItem->id }})"
                                class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Delete Item
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            <p class="font-bold">Total : Rp <span
                    id="totalPrice">{{ number_format($totalPrice, 0, ',', '.') }}</span></p>
        </div>
    </div>

    <div class="container mx-auto py-4">
        <button onclick="checkoutHandler(cartItems)"
            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            Checkout
        </button>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js" defer></script>

    <script>
        var cartItems = @json($cartItems);

        function setCsrfTokenHeader(xhr) {
            xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
        }


        function checkoutHandler(cartItems) {
            var isValid = true;

            for (var i = 0; i < cartItems.length; i++) {
                var cartItem = cartItems[i];
                var quantityInput = cartItem.quantity;
                var maxStock = cartItem.product.stock;
                var productId = cartItem.product.id;
                var productName = cartItem.product.namakue;

                var quantity = parseInt(quantityInput);

                if (quantity > maxStock) {
                    isValid = false;
                    console.log('Melebihi Stock');
                    Swal.fire({
                        icon: 'error',
                        title: 'Exceed Stock',
                        text: 'Quantity ' + productName + ' Exceed Existing Stock!',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6',
                    });
                }
            }

            if (isValid) {
                saveCheckoutData();
            }
        }


        document.querySelectorAll('.quantity-input').forEach(function(input) {
            input.addEventListener('change', function() {
                var cartItemId = input.getAttribute('data-cartitemid');
                var updatedQuantity = parseInt(input.value);

                for (var i = 0; i < cartItems.length; i++) {
                    if (cartItems[i].id === parseInt(cartItemId)) {
                        cartItems[i].quantity = updatedQuantity;
                        break;
                    }
                }
            });
        });

        function saveCheckoutData() {
            var checkoutItems = [];
            var totalPayment = document.getElementById('totalPrice').innerText.replace(/,/g, '');

            document.querySelectorAll('#cartTable tbody tr').forEach(function(row) {
                if (!row.cells || row.cells.length === 0) {
                    return;
                }
                var cartItemId = row.cells[3].querySelector('input').getAttribute(
                    'data-cartitemid');
                var name = row.cells[1].innerText;
                var price = row.cells[2].innerText.replace(/Rp /g, '').replace(/\./g, '');
                var quantity = row.cells[3].querySelector('input').value;
                var productId = row.cells[3].querySelector('input').getAttribute(
                    'data-productid');

                checkoutItems.push({
                    cartItemId: cartItemId,
                    productId: productId,
                    nama_produk: name,
                    harga: price,
                    quantity: quantity
                });
            });

            var data = {
                checkoutItems: checkoutItems,
                totalPayment: totalPayment
            };

            $.ajax({
                url: "{{ route('save_checkout_data') }}",
                type: "POST",
                data: data,
                beforeSend: setCsrfTokenHeader,
                success: function(response) {
                    if ('error' in response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: response.error,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6',
                        });
                    } else {
                        window.location.href = "{{ route('checkout') }}";
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var response = JSON.parse(xhr.responseText);
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: response.error,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6',
                        });
                    } else {
                        console.error(error);
                    }
                }
            });
        }
    </script>
@endsection
