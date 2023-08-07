<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Andhista Cookies</title>

    <link rel="stylesheet" href="@yield('css')">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>

    <link href='https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
    <link href='https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css' rel='stylesheet'
        type='text/css'>

    <style>
        #orderHeadersTable thead tr {
            cursor: pointer;
        }
    </style>
</head>


<body>
    @include('sweetalert::alert')
    <div id="app">
        @include('partials.navbar')

        <main class="py-4">
            @if (session('message'))
                <div id="message" class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    @include('partials.footer')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.7.0/flowbite.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js" defer></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js" defer></script>

    <script>
        function showSweetAlert() {
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful.',
                text: 'Data Added Successfully !!',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('getOrderHeaders') }}";
                }
            });
        }
    </script>




    <script>
        function removeCartItem(cartItemId) {
            fetch(`/cart/remove/${cartItemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const cartRow = document.querySelector(`[data-cartitemid="${cartItemId}"]`);
                    cartRow.remove();
                    const totalPrices = document.querySelectorAll('.total-price');
                    let totalPrice = 0;
                    totalPrices.forEach(item => {
                        totalPrice += parseInt(item.getAttribute('data-price'));
                    });
                    const totalPriceElement = document.getElementById('totalPrice');
                    totalPriceElement.innerText = `Rp ${totalPrice.toLocaleString('id-ID')}`;

                    Swal.fire({
                        icon: 'success',
                        title: 'Product Successfully Removed from Cart',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('quantity-input')) {
                const cartItemId = event.target.getAttribute('data-cartitemid');
                const newQuantity = parseInt(event.target.value);
                const pricePerItem = parseInt(event.target.closest('tr').querySelector('.price').innerText.replace(
                    'Rp ', '').replace(/\./g, ''));
                const totalItemPriceElement = event.target.closest('tr').querySelector('.total-price');
                const totalPriceElement = document.getElementById('totalPrice');

                const totalItemPrice = newQuantity * pricePerItem;
                totalItemPriceElement.innerText = `${totalItemPrice.toLocaleString('id-ID')}`;
                totalItemPriceElement.setAttribute('data-price', totalItemPrice);

                fetch(`/cart/update/${cartItemId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            quantity: newQuantity
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        const totalPrices = document.querySelectorAll('.total-price');
                        let totalPrice = 0;
                        totalPrices.forEach(item => {
                            totalPrice += parseInt(item.getAttribute('data-price'));
                        });
                        totalPriceElement.innerText = ` ${totalPrice.toLocaleString('id-ID')}`;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        });
    </script>
    <script>
        function updateCartData() {
            fetch('/cart/data')
                .then(response => response.json())
                .then(data => {
                    console.log('Cart Data:', data);
                    const cartItemCount = data.cart.length;
                    const totalQuantity = data.cart.reduce((total, item) => total + item.quantity, 0);

                    const cartItemCountElement = document.getElementById('cart-item-count');
                    const totalQuantityElement = document.getElementById('total-quantity');
                    const modalTotalQuantityElement = document.getElementById('modal-total-quantity');
                    const cartItemsListElement = document.getElementById('cart-items-list');

                    if (cartItemCount > 0) {
                        cartItemCountElement.textContent = cartItemCount.toString();
                        cartItemCountElement.classList.remove('hidden');
                    } else {
                        cartItemCountElement.textContent = '';
                        cartItemCountElement.classList.add('hidden');
                    }

                    totalQuantityElement.textContent = totalQuantity.toString();
                    modalTotalQuantityElement.textContent = totalQuantity.toString();

                    cartItemsListElement.innerHTML = '';

                    data.cart.forEach(item => {
                        const listItem = document.createElement('li');
                        listItem.textContent = `${item.product.namakue} - Quantity: ${item.quantity}`;
                        cartItemsListElement.appendChild(listItem);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }





        function addToCart(productId) {
            const quantityInput = document.getElementById('quantity');
            const quantity = parseInt(quantityInput.value);
            const maxStock = parseInt(quantityInput.max);

            if (quantity <= 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Quantity Salah',
                    text: 'Tolong masukkan quantity yang valid (Lebih dari 0).',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            if (quantity > maxStock) {
                Swal.fire({
                    icon: 'error',
                    title: 'Melebihi Stock',
                    text: 'Quantity Melebihi Stock yang ada!',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);

                    Swal.fire({
                        icon: 'success',
                        title: 'Product Successfully Added to Cart.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);

                    Swal.fire({
                        icon: 'error',
                        title: 'Failed to Add Product to Cart.',
                        text: 'Please Try Again or Contact Admin.',
                        confirmButtonText: 'OK'
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateCartData();
        });
    </script>



</body>

</html>
