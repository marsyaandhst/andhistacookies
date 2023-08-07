@extends('layouts.main')
@section('css', '/css/pembayaran.css')

@section('content')
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
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Pembayaran
                                        </th>
                                        <th scope="col" class="px-6 py-3">

                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            for="namapenerima">
                                            Nama Penerima
                                        </th>
                                        <td class="px-6 py-4">
                                            <input type="text" id="namapenerima" name="namapenerima"
                                                placeholder="Nama Penerima" required>
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            for="nohp">
                                            Nomor HP
                                        </th>
                                        <td class="px-6 py-4">
                                            <input type="number" id="nohp" name="nohp" placeholder="Nomor HP"
                                                required>
                                        </td>
                                    </tr>
                                    <tr class="bg-white dark:bg-gray-800">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            for="namakue">
                                            Nama Kue
                                        </th>
                                        <td class="px-6 py-4">
                                            <input type="text" name="namakue" value="{{ $product->namakue }}" readonly
                                                class="border-0">
                                        </td>
                                    </tr>
                                    <tr class="bg-white dark:bg-gray-800">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Harga
                                        </th>
                                        <td class="px-6 py-4">
                                            Rp. {{ number_format($product->harga, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            for="totalitem">
                                            Total Item
                                        </th>
                                        <td class="px-6 py-4">
                                            <input type="number" name="totalitem" placeholder="Total Item" value="1"
                                                required onchange="calculateTotal()">
                                        </td>
                                    </tr>
                                    <tr class="bg-white dark:bg-gray-800">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                                            for="totalharga">
                                            Total Harga
                                        </th>
                                        <td class="px-6 py-4">
                                            Rp. <input type="text" id="totalHarga" name="totalharga"
                                                value="{{ $product->harga }}" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="ml-14">
                                <label for="message"
                                    class="block mt-4 mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    for="alamat">Masukan Alamat</label>
                                <textarea id="message" name="alamat" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Tulisan Alamat Anda Disini..." required></textarea>

                                <label class="block my-2  text-sm font-medium text-gray-900 dark:text-white"
                                    for="multiple_files" for="buktipembayaran">Upload bukti transfer</label>
                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    id="multiple_files" type="file" name="buktipembayaran" required multiple>

                                <!-- validasi no HP -->
                                <div id="validasihp">

                                </div>

                                <button type="submit"
                                    class="text-white mt-4 bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2">Konfirmasi
                                    Pembayaran</button>
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
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-6 text-center">
                            <i class="fa-solid fa-thumbs-up fa-7x"></i>
                            <h3 class="mb-5 mt-3 text-lg font-normal text-gray-500 dark:text-gray-400">Pembayaran Anda
                                Success Harap Tunggu Konfirmasi</h3>
                            <button data-modal-hide="popup-modal" type="button"
                                class="text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                Ya, Terima Kasih
                            </button>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <script>
        function calculateTotal() {
            const harga = parseFloat({{ $product->harga }});
            let totalItem = parseFloat(document.getElementsByName('totalitem')[0].value);

            if (totalItem < 1) {
                totalItem = 1;
                document.getElementsByName('totalitem')[0].value = 1;
            }

            const totalHarga = harga * totalItem;
            document.getElementById('totalHarga').value = totalHarga;
        }

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
                    <span class="font-medium">Invalid nama!</span> Nama tidak boleh menggunakan ANGKA.
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
                    <span class="font-medium">Invalid No HP!</span> No HP tidak boleh kurang dari 11 dan lebih dari 13.
                </div>
            </div>`;
                return false;
            }



            containervalidasi.innerHTML = ''; // Clear the validation message if the input is valid
            return true;
        }
    </script>


@endsection
