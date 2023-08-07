@extends('layouts.main')
@section('css', '/css/style.css')

@section('content')

<section class="bg-center bg-no-repeat jumbotron" id="home">
    <div class="px-4 mx-auto max-w-screen-xl text-center py-24 lg:py-56">
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">Andhista Cookies</h1>
        <p class="mb-8 text-lg font-normal text-gray-100 lg:text-xl sm:px-16 lg:px-48">MADE WITH LOVE AND CARE</p>
        <div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
            <a href="#" class="inline-flex justify-center hover:text-gray-900 items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg border border-white hover:bg-gray-400 focus:ring-4 focus:ring-gray-400">
               Try Now
            </a>  
        </div>
    </div>
</section>

<section>
    <div class="text-center kue-header">
        <h3 class=" text-3xl font-extrabold mb-3">Taste the Extraordinary Serving of Andhista Cookies</h3>
        <p class="text-lg  text-gray-600 lg:text-xl sm:px-16 lg:px-48">Find Your Favorite Cookies at Andhista Cookies!</p>
    </div>

    
<div class="relative w-full mt-10" data-carousel="slide">
    <!-- Carousel wrapper -->
    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
         <!-- Item 1 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ asset('img/slider.jpeg') }}" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
        </div>
        <!-- Item 2 -->
        <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
            <img src="{{ asset('img/slider2.jpg') }}" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="">
        </div>
        @foreach ($product as $item)
        <div class="hidden duration-700 ease-in-out" data-carousel-item>
            <img src="{{ url('fotokue/' . $item->photo) }}" alt="{{ $item->namakue }}" class="absolute block max-w-full h-auto -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" >
        </div>
        @endforeach
    </div>
    <!-- Slider controls -->
    <button type="button" class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
    </button>
    <button type="button" class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
    </button>
</div>
</section>

    <section id="product">
    <h1 class="mt-4 text-4xl font-bold text-center">Our Product</h1>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 m-10">
        @foreach ($product as $item)
        <div class="img-product">
            <a href="/detailproduct/{{ $item->id }}">
                <img class="h-auto rounded-lg" src="{{ url('fotokue/' . $item->photo) }}" alt="{{ $item->namakue }}">
            </a>
        </div>
        @endforeach
    </div>

</section>

<section id="about-us" class="mt-40">
    <div class="flex justify-center m-10">
        <div class="flex flex-col items-center bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-5xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <img class="object-cover w-full ml-10 rounded-t-lg h-96 md:h-auto md:w-96 md:rounded-none md:rounded-l-lg" src="{{ asset('img/jumbotron.jpg') }}" alt="">
            <div class="flex flex-col justify-between p-4 leading-normal">
                <h5 class="mb-4 text-4xl font-bold tracking-tight text-gray-900 dark:text-white">About Us</h5>
                <p class="mb-2 font-bold text-justify text-gray-700 dark:text-gray-400">
                Andhista Cookies
                </p>
                <p class="mb-2 font-normal text-justify text-gray-700 dark:text-gray-400">
                Menyediakan aneka kue kering favorit, seperti kue Almonds, Nastar, Cornflake, Sagu Keju, Putri Salju, Kastengel.
                </p>
                <p class="mb-3 font-normal text-justify text-gray-700 dark:text-gray-400">
                Kami berdiri sejak tahun 2008, melayani Anda dengan memproduksi kue-kue kering favorit Anda dengan cita rasa yang prima dan menggunakan bahan-bahan berkualitas tinggi dengan label produk halal.
                </p>
            </div>
        </div>
    </div>
</section>


@endsection
