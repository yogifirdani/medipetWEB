<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HistoryPesanan;
use App\Http\Controllers\ManageOrderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\RestockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ViewOrderController;
use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\type;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//  jika user belum login
Route::group(['middleware' => 'guest'], function () {
    Route::get('/', [AuthController::class, 'login']);
    Route::post('/', [AuthController::class, 'dologin']);

    //regist customer
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'doRegister']);
});

// untuk superadmin dan customer
Route::group(['middleware' => ['auth', 'checkrole:1,2']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/redirect', [RedirectController::class, 'cek']);
});

// untuk admin
Route::group(['middleware' => ['auth', 'checkrole:1']], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/search', [ProductController::class, 'index'])->name('products.search');
    Route::get('/products/add', [ProductController::class, 'add'])->name('products.add');
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::get('/products/search', [ProductController::class, 'search']);

    //    Konsultasi
    Route::get('/konsultasiadmin', [\App\Http\Controllers\KonsultasiController::class, 'indexadmin']);
    Route::post('/konsultasiadmin', [\App\Http\Controllers\KonsultasiController::class, 'storeadmin']);
    Route::post('/konsultasiadmin/{id}', [\App\Http\Controllers\KonsultasiController::class, 'storeCommentadmin']);



    Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs.index');

    // manage order
    Route::get('/transaksi/create', [ManageOrderController::class, 'create'])->name('transaksi.create');
    Route::get('/transaksi', [ManageOrderController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{id}', [ManageOrderController::class, 'show'])->name('transaksi.show');
    Route::post('/transaksi', [ManageOrderController::class, 'store'])->name('transaksi.store');
    Route::post('/transaksi/{id}', [ManageOrderController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{id}', [ManageOrderController::class, 'destroy'])->name('transaksi.destrpy');

    Route::get('/get-product-price/{id}', [ManageOrderController::class, 'getProductPrice']);

    //order
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/{id}/process', [OrderController::class, 'processOrder'])->name('orders.process');
    Route::post('/orders/{id}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');

    //kategori
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    //restock
    // Route::get('/restocks', [RestockController::class, 'index'])->name('restocks.index');
    // Route::get('/restocks/create', [RestockController::class, 'create'])->name('restocks.create');
    // Route::get('/restocks/edit/{$id_restock}', [RestockController::class, 'edit'])->name('restocks.edit');
    // Route::put('/restocks/{id_restock}', [RestockController::class, 'update'])->name('restocks.update');
    // Route::post('/restocks', [RestockController::class, 'store'])->name('restocks.store');
    // Route::get('/restocks/{id}', [RestockController::class, 'show'])->name('restocks.show');
    Route::resource('restocks', RestockController::class);
    // Route::delete('/restocks/{id_restock}', [RestockController::class, 'destroy'])->name('restocks.destroy');

    Route::get('/pemasukan', [PemasukanController::class, 'index'])->name('laporan.pemasukan');
    Route::get('/pemasukan/pdf', [PemasukanController::class, 'generatePDF'])->name('laporan.pemasukan.pdf');
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])->name('laporan.pengeluaran');
    Route::get('/pengeluaran/pdf', [PengeluaranController::class, 'generatePDF'])->name('laporan.pengeluaran.pdf');
});

// untuk customer
Route::group(['middleware' => ['auth', 'checkrole:2']], function () {
    Route::get('/customer', [DashboardController::class, 'index'])->name('dashboard.index');

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Catalog
    Route::get('/catalogs', [CatalogController::class, 'index'])->name('catalogs.index');
    Route::get('/catalogs/{id}', [CatalogController::class, 'show'])->name('catalogs.show');
    Route::post('/catalogs/{id}/addtocart', [CatalogController::class, 'addToCart'])->name('catalogs.addToCart');


    // Konsultasi
    Route::get('/konsultasi', [\App\Http\Controllers\KonsultasiController::class, 'index']);
    Route::post('/konsultasi', [\App\Http\Controllers\KonsultasiController::class, 'store']);
    Route::post('/konsultasi/{id}', [\App\Http\Controllers\KonsultasiController::class, 'storeComment']);

    // Booking
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');

    // keranjang + co
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/add/{id}', [CartController::class, 'addtocart'])->name('cart.addtocart');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'removeitem'])->name('cart.remove');
    // Route::post('/beli/{id}', [CartController::class, 'cart'])->name('checkout');
    Route::post('/pemesanan', [CartController::class, 'checkout'])->name('pemesanan');
    Route::get('/pemesanan', [CartController::class, 'co'])->name('co');
    Route::post('/pembelian', [CartController::class, 'pembelian'])->name('pembelian');
    Route::get('/pesanan/success', [CartController::class, 'success'])->name('success');

    // view order
    Route::get('/view', [ViewOrderController::class, 'show'])->name('view');

    //history
    Route::get('/history', [HistoryController::class, 'show'])->name('history');
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');
});
