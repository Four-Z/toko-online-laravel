<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

//user
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'list_all'])->name('products');
Route::get('/products/{nama}', [HomeController::class, 'list_by_kategori']);
Route::get('/products/{nama}/{id}', [HomeController::class, 'product_detail'])->name('product.detail');
Route::post('masuk-keranjang', [HomeController::class, 'masuk_keranjang'])->name('masuk.keranjang');
Route::get('/keranjang', [HomeController::class, 'keranjang'])->name('keranjang');
Route::delete('/hapus-pesanan/{id}', [HomeController::class, 'hapus_pesanan']);
Route::get('/checkout_page', [HomeController::class, 'checkout_page'])->name('checkout.page');
Route::post('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::get('/history', [HomeController::class, 'history'])->name('history');

//admin
Route::get('/admin', [HomeController::class, 'admin'])->name('admin');
Route::get('/admin/home', [HomeController::class, 'admin'])->name('admin.home');
Route::get('/admin/statistik', [HomeController::class, 'show_statistic'])->name('admin.statistik');
Route::post('/admin/statistik-byDate', [HomeController::class, 'show_statistic_byDate'])->name('statistik.date');
Route::get('/admin/laporan-penjualan', [HomeController::class, 'laporan_penjualan'])->name('admin.laporan-penjualan');
Route::post('/admin/laporan_penjualan-filtered', [HomeController::class, 'laporan_penjualan_filtered'])->name('admin.laporan-penjualan-filtered');
Route::get('/admin/semua-products', [HomeController::class, 'admin_products'])->name('admin.products');
Route::delete('admin/hapus-product/{id}', [HomeController::class, 'hapus_product'])->name('admin.hapusProduct');
Route::get('/admin/tambah-product', [HomeController::class, 'tambah_product_page'])->name('admin.tambah_product');
Route::post('/admin/store-product', [HomeController::class, 'tambah_product'])->name('admin.store_product');
Route::get('/admin/edit-product/{id}', [HomeController::class, 'edit_product_page'])->name('admin.edit_product');
Route::post('/admin/update-product', [HomeController::class, 'edit_product'])->name('admin.update_product');
Route::get('/admin/statistik/generate-pdf', [HomeController::class, 'generatePDF'])->name('admin.generatePDF');
Route::get('/admin/laporan-beban', [HomeController::class, 'laporan_beban'])->name('admin.laporan-beban');
Route::get('/admin/laporan-laba', [HomeController::class, 'laporan_laba'])->name('admin.laporan-laba');
Route::post('/admin/laporan-laba-filtered', [HomeController::class, 'laporan_laba_filtered'])->name('admin.laporan-laba-filtered');
