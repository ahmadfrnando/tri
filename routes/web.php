<?php

use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\HandphoneController;
use App\Http\Controllers\KelolaBarangRusakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatBarangKeluarController;
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


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [HandphoneController::class, 'index']);
    Route::resource('handphone', HandphoneController::class);
    Route::resource('barang-keluar', BarangKeluarController::class);
    Route::resource('riwayat-barang-keluar', RiwayatBarangKeluarController::class);
    Route::resource('kelola-barang-rusak', KelolaBarangRusakController::class);
    Route::get('/search-handphone', [HandphoneController::class, 'search'])->name('search.handphone');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('kliping', [BarangKeluarController::class, 'getKliping']);

require __DIR__ . '/auth.php';
