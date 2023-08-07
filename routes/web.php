<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'showproduct'])->name('showproduct');
Route::get('/detailproduct/{id}', [HomeController::class, 'showproductdetail']);
Route::post('/cart/add', [HomeController::class, 'addToCart']);
Route::get('/cart/data', [HomeController::class, 'getCartData']);
Route::get('/shopping-cart', [HomeController::class, 'showShoppingCart']);
Route::post('/save_checkout_data', [HomeController::class, 'saveCheckoutData'])->name('save_checkout_data');
Route::post('/cart/update/{cartItemId}', [HomeController::class, 'updateQuantity']);
Route::post('/cart/remove/{cartItemId}', [HomeController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::get('/pembayaranproduct/{id}', [HomeController::class, 'pembayaranproduct'])->name('pembayaranproduk');
Route::post('/pembayaranproduct/insertpembayaran', [HomeController::class, 'insertpembayaran'])->name('bayarproduk');
Route::get('/getOrderHeaders', [HomeController::class, 'getOrderHeaders'])->name('getOrderHeaders');
Route::get('/api/order_details/{orderId}', [HomeController::class, 'getOrderDetails'])->name('getOrderDetails');
Route::post('/get_product_data', [HomeController::class, 'getProductData'])->name('get_product_data');



Route::group(['middleware' => ['Auth', 'Admin']], function () {
    Route::get('/admin', [ProductController::class, 'index'])->name('admin');
    Route::get('/admin/add', [ProductController::class, 'add']);
    Route::post('/admin/insert', [ProductController::class, 'insert']);
    Route::get('/admin/detailproduk/{id}', [ProductController::class, 'detail']);
    Route::get('/admin/edit/{id}', [ProductController::class, 'edit']);
    Route::post('/admin/update/{id}', [ProductController::class, 'update']);
    Route::get('/admin/delete/{id}', [ProductController::class, 'delete']);
    Route::get('/daftarpesanan', [ProductController::class, 'showorder'])->name('daftarpesanan');
    Route::get('/daftarpesanan/detail/{id}', [ProductController::class, 'detailorder']);
    Route::get('/daftarpesanan/delete/{id}', [ProductController::class, 'deletepesanan']);
    Route::patch('/api/update_status/{orderId}', [ProductController::class, 'updatestatus'])->name('updatestatus');
    Route::get('/adminGetOrderHeaders', [ProductController::class, 'adminGetOrderHeaders'])->name('adminGetOrderHeaders');
    Route::get('/api/adminOrder_details/{orderId}', [ProductController::class, 'adminGetOrderDetails'])->name('adminGetOrderDetails');

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
