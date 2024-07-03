<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PasarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomoditiController;
use App\Http\Controllers\RiwayatHargaKomoditiController;
use App\Http\Controllers\ProdukKomoditiController;

use App\Http\Controllers\HomeController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified'])->name('home');

Route::resource('pasar', PasarController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('komoditi', KomoditiController::class);
Route::resource('riwayat_harga_komoditi', RiwayatHargaKomoditiController::class);
Route::resource('produk_komoditi', ProdukKomoditiController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

route::get('home', [HomeController::class, 'index'])->name('home');
// Route untuk import dan export data pasar
Route::post('pasar/import', [PasarController::class, 'import'])->name('pasar.import')->middleware(['auth', 'admin']);
Route::get('/pasar_export', [PasarController::class, 'export'])->name('pasar.export')->middleware(['auth', 'admin']);
Route::get('/pasar_preview', [PasarController::class, 'preview'])->name('pasar.preview')->middleware(['auth', 'admin']);
// Route untuk import dan export data riwayat harga komoditi
Route::post('riwayat_harga_komoditi/import', [RiwayatHargaKomoditiController::class, 'import'])->name('riwayat_harga_komoditi.import')->middleware(['auth', 'admin']);
Route::get('/harga_komoditi_export', [RiwayatHargaKomoditiController::class, 'export'])->name('riwayat_harga_komoditi.export')->middleware(['auth', 'admin']);
Route::get('/harga_komoditi_preview', [RiwayatHargaKomoditiController::class, 'preview'])->name('riwayat_harga_komoditi.peview')->middleware(['auth', 'admin']);
// Route untuk import dan export data kategori
Route::post('kategori/import', [KategoriController::class, 'import'])->name('kategori.import')->middleware(['auth', 'admin']);
Route::get('/kategori_export', [KategoriController::class, 'export'])->name('kategori.export')->middleware(['auth', 'admin']);
Route::get('/kategori_preview', [KategoriController::class, 'preview'])->name('kategori.preview')->middleware(['auth', 'admin']);
// Route untuk import dan export data produk komoditi
Route::post('produk_komoditi/import', [ProdukKomoditiController::class, 'import'])->name('produk_komoditi.import')->middleware(['auth', 'admin']);
Route::get('/produk_export', [ProdukKomoditiController::class, 'export'])->name('produk_komoditi.export')->middleware(['auth', 'admin']);
Route::get('/produk_preview', [ProdukKomoditiController::class, 'preview'])->name('produk_komoditi.preview')->middleware(['auth', 'admin']);
// Route untuk import dan export data produk komoditi
Route::get('/komoditi_export', [KomoditiController::class, 'export'])->name('komoditi.export')->middleware(['auth', 'admin']);
Route::get('/komoditi_preview', [KomoditiController::class, 'preview'])->name('komoditi.preview')->middleware(['auth', 'admin']);