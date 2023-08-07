<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<header class="absolute inset-x-0 top-0 z-50">
    <nav class="bg-white border-gray-200 dark:bg-gray-900">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl p-4">
            <a href="{{ url('/') }}" class="flex items-center">
                <i class="fa-solid fa-cookie-bite fa-2xl mr-2"></i>
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Andhista
                    Cookies</span>
            </a>
            <div class="flex items-center">
                <a href="https://wa.me/081282477582?text=Halo,%20saya%20ingin%20tahu%20lebih%20banyak%20tentang%20layanan%20Anda,%20Bisakah%20membantuku?"
                    class="mr-6 text-sm  text-gray-500 dark:text-white hover:underline">+62 812-8247-7582 </a>

                @guest
                    @if (Route::has('login'))
                        <button type="button"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <a href="{{ route('login') }}" class="text-sm hover:underline">Login</a>
                        </button>
                    @endif
                @else
                    <button type="button"
                        class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="{{ asset('img/user.jpg') }}" alt="user photo">
                    </button>
                    <!-- Dropdown menu -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                            <span
                                class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                @if (Auth::user()->status == 1)
                                    <a href="/admin"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                                @endif
                                <a href="{{ route('logout') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                                    out</a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                @endguest
            </div>
        </div>
    </nav>
    <nav class="bg-gray-50 dark:bg-gray-700">
        <div class="max-w-screen-xl px-4 py-3 mx-auto">
            <div class="flex items-center">
                <ul class="flex flex-row font-medium mt-0 mr-6 space-x-8 text-sm">
                    <li>
                        <a href="/" class="text-gray-900 dark:text-white hover:underline"
                            aria-current="page">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#product"
                            class="text-gray-900 dark:text-white hover:underline">Product</a>
                    </li>
                    <li>
                        <a href="{{ url('/') }}#about-us"
                            class="text-gray-900 dark:text-white hover:underline">About Us</a>
                    </li>
                    <li>
                        <a href="#contact-us" class="text-gray-900 dark:text-white hover:underline">Contact Us</a>
                    </li>
                    <li>
                        @auth
                            <a href="/getOrderHeaders" class="text-gray-900 dark:text-white hover:underline">History</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-gray-900 dark:text-white hover:underline">History</a>
                        @endauth

                    </li>
                    @auth
                        <li>
                            <div class="flex items-center space-x-1">
                                <a href="/shopping-cart" class="hover:text-blue-700">
                                    <i class="fa-solid fa-shopping-cart" id="cart-item-count"></i>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <span>Total Quantity:</span>
                                <span id="total-quantity"></span>
                            </div>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>



</header>
