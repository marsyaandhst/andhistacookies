@extends('layouts.main')
@section('css', '/css/detailproduct.css')

@section('content')
    <section class="detail-produk">
        <div class="container">
            <div class="row">
                <div class="col-md-6 img-produk">
                    <img src="{{ url('fotokue/' . $product->photo) }}" alt="{{ $product->namakue }}"
                        class=" h-auto rounded-t-lg">
                </div>
                <div class="col-md-6 text-justify">
                    <h2 class="text-2xl font-semibold">{{ $product->namakue }}</h2>
                    <p class="text-lg mt-2 ">Rp. {{ number_format($product->harga, 0, ',', '.') }}</p>
                    <p class="mt-4 pr-10">
                        {{ $product->deskripsi }}
                    <div class="mt-6">
                        <p class="mb-2 text-xl">Stock : {{ $product->stock }}</p>

                    </div>
                    <div class="mt-6">
                        <label for="quantity" class="mb-2 text-xl">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1"
                            max="{{ $product->stock }}" class="mr-4 px-3 py-2 border rounded-lg text-sm">
                        <button type="button"
                            class="text-white mt-3 bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                            onclick="addToCart({{ $product->id }})">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
