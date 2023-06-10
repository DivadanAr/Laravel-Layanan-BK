<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruBkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\WalasController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('users.home');
});

Route::get('/siswas', function () {
    return view('users.siswa');
});

Route::get('/private-view', function () {
    return view('users.view-private');
});
Route::get('/study-view', function () {
    return view('users.view-study');
});
Route::get('/career-view', function () {
    return view('users.view-career');
});
Route::get('/social-view', function () {
    return view('users.view-social');
});

Route::get('/signin', function () {
    return view('signin');
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'role:admin|guru_bk|wali_kelas'
])->group(function () {
    Route::resource('siswa', SiswaController::class);
    Route::resource('guru', GuruBkController::class);
    Route::resource('walas', WalasController::class);
    Route::resource('dashboard', DashboardController::class);
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/home', function () {
        return view('users.index');
    })->name('home');
});



// Route::get('/dashboard', function() {
//     return view('dashboard');
// })->middleware('role:admin')->name('admin.page');

// Route::get('/', function() {
//     return view('welcome');
// })->middleware('role:user')->name('user.page');