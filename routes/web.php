<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\AdminOrderController;


// Halaman utama (landing)
Route::get('/', fn () => view('welcome'));

// Katalog produk (publik)
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{product}', [ProductController::class, 'show'])->name('katalog.show');

// Rute untuk halaman "Tentang Kami" - Bisa diakses publik
Route::get('/about-us', function () {
    return view('about');
})->name('about.us');

// Dashboard pengguna (user biasa)
Route::get('/dashboard', fn () => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Grup route untuk pengguna login & verifikasi
Route::middleware(['auth', 'verified'])->group(function () {
    // Profil pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'updateProfileInformation'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.photo.delete');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Keranjang & Checkout
    Route::get('/cart', [CartController::class, 'cart'])->name('cart.cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    // Checkout POST akan memanggil OrderController@checkout
    Route::post('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    // Checkout success (mungkin menampilkan detail order)
    Route::get('/checkout/success', [CartController::class, 'success'])->name('checkout.success'); // Pertimbangkan OrderController@success jika lebih ke order
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Riwayat Pesanan (Pengguna)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    // Menggunakan Route Model Binding: {order} akan otomatis mengambil instance Order berdasarkan ID
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    // untuk bukti pembayaran
    Route::post('/orders/{order}/upload-proof', [OrderController::class, 'uploadProof'])->name('orders.uploadProof');
});

// ADMIN AREA
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/export-excel', [ReportController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export-pdf', [ReportController::class, 'exportPDF'])->name('export.pdf');
    Route::post('/import-excel', [ReportController::class, 'importExcel'])->name('import.excel');

    Route::get('/orders', [AdminOrderController::class, 'status'])->name('orders.status');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::put('/orders/{order}/update-payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.updatePaymentStatus');
    Route::get('/orders/{order}/print', [AdminOrderController::class, 'print'])->name('orders.print');

    // Produk
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    // Pesanan Admin
    // Menggunakan admin() di OrderController, beri nama 'orders.index' agar konsisten dengan Convention
    Route::get('/orders', [OrderController::class, 'admin'])->name('orders.index');
    // Perhatikan Route Model Binding {order}
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::post('/orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.updatePayment');
    // Menggunakan {order} untuk print dan show
    Route::get('/orders/{order}/print', [AdminOrderController::class, 'print'])->name('orders.print');
    Route::get('/orders/{order}/detail', [AdminOrderController::class, 'show'])->name('orders.show'); // Nama route yang lebih spesifik untuk admin
});

// Route default dari Laravel Breeze / Fortify
require __DIR__.'/auth.php';
