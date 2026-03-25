<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\PemesananController;
use Illuminate\Support\Facades\Route;
use App\Models\Wisata;

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
// Route Wisata
// Route::get('/editWisata/{wisata}', [WisataController::class, 'show'])->name('editWisata');
Route::get('editWisata/{id}', [WisataController::class, 'edit'])->name('editWisata');

Route::get('/history-transactions', [WisataController::class, 'historyTransactions'])->name('history');
Route::post('updateWisata/{id}/update', [WisataController::class, 'update'])->name('updateWisata');
Route::delete('updateWisata/{id}/delete', [WisataController::class, 'delete'])->name('deleteWisata');
Route::post('registWisata', [WisataController::class, 'store'])->name('registWisata');
Route::get('/search', [WisataController::class, 'search'])->name('wisata.search');
// Route::post('registWisata', [WisataController::class, 'asal'])->name('manageWisata');
Route::get('viewWisata', [WisataController::class, 'index'])->name('viewWisata');
Route::get('kelolaWisata', [WisataController::class, 'kelola'])->name('kelolaWisata');
Route::get('getWisata', [WisataController::class, 'getWisata'])->name('getaWisata');
Route::get('/pemesanan', [PemesananController::class, 'index'])->name('wisatawan.pemesanan');
// Route::post('pemesanan', [PemesananController::class, 'store'])->name('pemesanan');
Route::post('/pemesanan', [PemesananController::class, 'store'])->name('pemesanan.store');

Route::post('/proses-pilih-tiket', [PemesananController::class, 'prosesPilihTiket'])->name('prosesPilihTiket');
Route::get('/pemesanan', [PemesananController::class, 'halamanPemesanan'])->name('halamanPemesanan');


Route::get('/informasi/{id}', [WisataController::class, 'informasi'])->name('informasi.show');

Route::get('/mitra', [WisataController::class, 'mitra'])->name('mitra');

// Dashboard — accessible by both guests and logged-in users
Route::get('/dashboard', function () {
    $destinations = Wisata::with('images')->get();
    return view('dashboard', compact('destinations'));
})->name('dashboard');

Route::get('/', function () {
    $destinations = Wisata::with('images')->get();
    return view('dashboard', compact('destinations'));
});



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
