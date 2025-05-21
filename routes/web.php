<?php

use App\Exports\HandphoneExport;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HandphoneController;
use App\Http\Controllers\KelolaBarangRusakController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RiwayatBarangKeluarController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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


Route::get('/dashboard', [HandphoneController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', [HandphoneController::class, 'index'])->name('index');
    Route::resource('handphone', HandphoneController::class);
    Route::resource('barang-keluar', BarangKeluarController::class);
    Route::resource('riwayat-barang-keluar', RiwayatBarangKeluarController::class);
    Route::resource('kelola-barang-rusak', KelolaBarangRusakController::class);
    Route::get('/search-handphone', [HandphoneController::class, 'search'])->name('search.handphone');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('export/semua-barang/', [ExportController::class, 'semuaBarang'])->name('semua-barang.export');
    Route::get('export/barang-masuk/', [ExportController::class, 'barangMasuk'])->name('barang-masuk.export');
    Route::get('export/barang-keluar/', [ExportController::class, 'barangKeluar'])->name('barang-keluar.export');
    Route::get('export/barang-rusak/', [ExportController::class, 'barangRusak'])->name('barang-rusak.export');
});

// Route::get('kliping', [BarangKeluarController::class, 'getKliping']);
// Route::get('/handphone/export', function (\Illuminate\Http\Request $request) {
//         $bulanMulai = $request->input('bulan_mulai');
//         $bulanAkhir = $request->input('bulan_akhir');

//         return Excel::download(new HandphoneExport($bulanMulai, $bulanAkhir), 'daftar-handphone.xlsx');
//     })->name('handphone.export');
Route::get('users/export/', [UsersController::class, 'export'])->name('users.export');

require __DIR__ . '/auth.php';
