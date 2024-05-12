<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RedirectController;
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
Route::group(['middleware' => 'guest'], function() {
    Route::get('/', [AuthController::class, 'login']);
    Route::post('/', [AuthController::class, 'dologin']);
});

// untuk superadmin dan pegawai
Route::group(['middleware' => ['auth', 'checkrole:1,2']], function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/redirect', [RedirectController::class, 'cek']);
});

// untuk admin
Route::group(['middleware' => ['auth', 'checkrole:1']], function() {
    Route::get('/admin', [AdminController::class,'index']);

});

// untuk customer
Route::group(['middleware' => ['auth', 'checkrole:2']], function() {
    Route::get('/customer', [CustomerController::class,'index']);

});
















































// Route::get('login', function () {
//     return view('pages.auth.auth-login', ['type_menu' => 'auth']);
// });

// Route::get('register', function () {
//     return view('pages.auth.auth-register', ['type_menu' => 'auth']);
// });

// Route::get('reset-password', function () {
//     return view('pages.auth.auth-reset-password', ['type_menu' => 'auth']);
// });

// Route::get('forgot-password', function () {
//     return view('pages.auth.auth-forgot-password', ['type_menu' => 'auth']);
// });




