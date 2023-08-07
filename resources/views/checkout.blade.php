@extends('layouts.main')
@section('css', '/css/pembayaran.css')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <section class="detail-pembayaran">
        <div class="container">
            <div class="row">
                <div class="col-md-5 pembayaran">
                    <div class="relative">
                        <table class="w-full ml-14 text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Bank
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        No Rekening
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        BCA
                                    </th>
                                    <td class="px-6 py-4">
                                        8820843984
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5 text-justify">
                    <div class="relative ml-10">
                        <form action="{{ route('bayarproduk') }}" method="POST" enctype="multipart/form-data"
                            onsubmit="return validatePhoneNumber()">
                            @csrf
                            <table class="w-full ml-14 text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <h2 class="text-xl font-semibold mt-4 mb-2">Checkout Product Details :</h2>

                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Payments
                                        </th>
                                        <th scope="col" class="px-6 py-3">

                                        </th>
                                    </tr>
                                </thead>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                        for="namapenerima">
                                        Recipients Name
                                    </th>
                                    <td class="px-6 py-4">
                                        <input type="text" id="namapenerima" name="namapenerima"
                                            placeholder="Recipients Name" required>
                                    </td>
                                </tr>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                        for="nohp">
                                        Phone Number
                                    </th>
                                    <td class="px-6 py-4">
                                        <input type="number" id="nohp" name="nohp" placeholder="Phone Number" required>
                                    </td>
                                </tr>
                                <table class="w-full ml-14 text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3">Product Name</th>
                                            <th scope="col" class="px-6 py-3">Price</th>
                                            <th scope="col" class="px-6 py-3">Quantity</th>
                                            <th scope="col" class="px-6 py-3">Total x Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($checkoutData)
                                            @foreach ($checkoutData['checkoutItems'] as $item)
                                                <tr class="bg-white dark:bg-gray-800">
                                                    <td
                                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                        {{ $item['nama_produk'] }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        Rp. {{ number_format($item['harga'], 0, ',', '.') }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        {{ $item['quantity'] }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        Rp.
                                                        {{ number_format($item['harga'] * $item['quantity'], 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    <p class="font-bold">Total Payment : <span id="totalPembayaran"></span></p>
                                </div>
                            </table>



                            <div class="ml-14">
                                <label for="message"
                                    class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="alamat">Address</label>
                                <textarea id="message" name="alamat" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Write Your Address Here..." required></textarea>

                                <label class="block my-2  text-sm font-medium text-gray-900 dark:text-white"
                                    for="multiple_files" for="buktipembayaran">Upload Proof Payment</label>
                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="multiple_files" type="file" name="buktipembayaran" required multiple>

                                <!-- validasi no HP -->
                                <div id="validasihp">

                                </div>

                                <button type="submit"
                                    class="text-white mt-4 bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">Confirm Payments</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            <div id="popup-modal" tabindex="-1"
                class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="popup-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-6 text-center">
                            <i class="fa-solid fa-thumbs-up fa-7x"></i>
                            <h3 class="mb-5 mt-3 text-lg font-normal text-gray-500 dark:text-gray-400">Your Payment
                                Success Please Wait for Confirmation</h3>
                            <button data-modal-hide="popup-modal" type="button"
                                class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Yes, Thank You
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </section>





    <script>
        function showSweetAlert() {
            Swal.fire({
                icon: 'success',
                title: 'Pembayaran Berhasil',
                text: 'Data Berhasil Ditambahkan !!',
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
        function calculateTotalPayment() {
            const checkoutItems = @json($checkoutData['checkoutItems']);
            let totalPayment = 0;

            checkoutItems.forEach(item => {
                totalPayment += item.harga * item.quantity;
            });

            document.getElementById('totalPembayaran').innerText = formatCurrency(totalPayment);
        }

        calculateTotalPayment();

        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(amount);
        }
    </script>


    <script>
        function validatePhoneNumber() {
            const phoneNumber = document.getElementsByName('nohp')[0].value;
            const name = document.getElementsByName('namapenerima')[0].value;
            const containervalidasi = document.getElementById('validasihp');

            if (/\d/.test(name)) {
                containervalidasi.innerHTML = `
            <div class="flex items-center my-2 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Invalid name!</span> Names cannot use NUMBERS.
                </div>
            </div>`;
                return false;
            }

            if (phoneNumber.length < 11 || phoneNumber.length > 13) {
                containervalidasi.innerHTML = `
            <div class="flex items-center my-2 p-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Info</span>
                <div>
                    <span class="font-medium">Invalid phone number!</span> Phone number cannot be less than 11 and more than 13.
                </div>
            </div>`;
                return false;
            }



            containervalidasi.innerHTML = ''; // Clear the validation message if the input is valid
            return true;
        }
    </script>


@endsection
