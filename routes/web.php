<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PasarController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KomoditiController;
use App\Http\Controllers\RiwayatHargaKomoditiController;
use App\Http\Controllers\ProdukKomoditiController;
use App\Http\Controllers\TelegramBotController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

route::get('home', [HomeController::class, 'index'])->name('home');

// Route untuk Developer Profile Page
Route::get('/developer', [DeveloperController::class, 'index'])->name('developer.index');

// Telegram bot webhooks
Route::group(['prefix' => 'telegram'], function(){
    Route::get('set-webhook', [TelegramBotController::class, 'setWebhook'])
        ->middleware(['auth', 'admin'])
        ->name('telegram.setWebhook');
    Route::match(['get', 'post'], 'webhook/{token}',[TelegramBotController::class, 'webhook']);
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Pasar
    Route::get('/pasar_create', [PasarController::class, 'create'])->name('pasar.create');
    Route::post('/pasar', [PasarController::class, 'store'])->name('pasar.store');
    Route::get('/pasar/{pasar}/edit', [PasarController::class, 'edit'])->name('pasar.edit');
    Route::put('/pasar/{pasar}', [PasarController::class, 'update'])->name('pasar.update');
    Route::delete('/pasar/{pasar}', [PasarController::class, 'destroy'])->name('pasar.destroy');

    // Kategori
    Route::get('/kategori_create', [KategoriController::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Komoditi
    Route::get('/komoditi_create', [KomoditiController::class, 'create'])->name('komoditi.create');
    Route::post('/komoditi', [KomoditiController::class, 'store'])->name('komoditi.store');
    Route::get('/komoditi/{komoditi}/edit', [KomoditiController::class, 'edit'])->name('komoditi.edit');
    Route::put('/komoditi/{komoditi}', [KomoditiController::class, 'update'])->name('komoditi.update');
    Route::delete('/komoditi/{komoditi}', [KomoditiController::class, 'destroy'])->name('komoditi.destroy');

    // Riwayat Harga Komoditi
    Route::get('/riwayat_harga_komoditi_create', [RiwayatHargaKomoditiController::class, 'create'])->name('riwayat_harga_komoditi.create');
    Route::post('/riwayat_harga_komoditi', [RiwayatHargaKomoditiController::class, 'store'])->name('riwayat_harga_komoditi.store');
    Route::get('/riwayat_harga_komoditi/{riwayat_harga_komoditi}/edit', [RiwayatHargaKomoditiController::class, 'edit'])->name('riwayat_harga_komoditi.edit');
    Route::put('/riwayat_harga_komoditi/{riwayat_harga_komoditi}', [RiwayatHargaKomoditiController::class, 'update'])->name('riwayat_harga_komoditi.update');
    Route::delete('/riwayat_harga_komoditi/{riwayat_harga_komoditi}', [RiwayatHargaKomoditiController::class, 'destroy'])->name('riwayat_harga_komoditi.destroy');

    // Produk Komoditi
    Route::get('/produk_komoditi_create', [ProdukKomoditiController::class, 'create'])->name('produk_komoditi.create');
    Route::post('/produk_komoditi', [ProdukKomoditiController::class, 'store'])->name('produk_komoditi.store');
    Route::get('/produk_komoditi/{produk_komoditi}/edit', [ProdukKomoditiController::class, 'edit'])->name('produk_komoditi.edit');
    Route::put('/produk_komoditi/{produk_komoditi}', [ProdukKomoditiController::class, 'update'])->name('produk_komoditi.update');
    Route::delete('/produk_komoditi/{produk_komoditi}', [ProdukKomoditiController::class, 'destroy'])->name('produk_komoditi.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Pasar routes
    Route::get('/pasar', [PasarController::class, 'index'])->name('pasar.index');
    Route::get('/pasar/{pasar}', [PasarController::class, 'show'])->name('pasar.show');

    // Kategori routes
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/kategori/{kategori}', [KategoriController::class, 'show'])->name('kategori.show');

    // Komoditi routes
    Route::get('/komoditi', [KomoditiController::class, 'index'])->name('komoditi.index');
    Route::get('/komoditi/{komoditi}', [KomoditiController::class, 'show'])->name('komoditi.show');

    // Riwayat Harga Komoditi routes
    Route::get('/riwayat_harga_komoditi', [RiwayatHargaKomoditiController::class, 'index'])->name('riwayat_harga_komoditi.index');
    Route::get('/riwayat_harga_komoditi/{riwayat_harga_komoditi}', [RiwayatHargaKomoditiController::class, 'show'])->name('riwayat_harga_komoditi.show');

    // Produk Komoditi routes
    Route::get('/produk_komoditi', [ProdukKomoditiController::class, 'index'])->name('produk_komoditi.index');
    Route::get('/produk_komoditi/{produk_komoditi}', [ProdukKomoditiController::class, 'show'])->name('produk_komoditi.show');
    
    
    // Route untuk import dan export data pasar
    Route::post('pasar/import', [PasarController::class, 'import'])->name('pasar.import')->middleware(['auth', 'admin']);
    Route::get('/pasar_export', [PasarController::class, 'export'])->name('pasar.export');
    Route::get('/pasar_preview', [PasarController::class, 'preview'])->name('pasar.preview');
    // Route untuk import dan export data riwayat harga komoditi
    Route::post('riwayat_harga_komoditi/import', [RiwayatHargaKomoditiController::class, 'import'])->name('riwayat_harga_komoditi.import')->middleware(['auth', 'admin']);
    Route::get('/harga_komoditi_export', [RiwayatHargaKomoditiController::class, 'export'])->name('riwayat_harga_komoditi.export');
    Route::get('/harga_komoditi_preview', [RiwayatHargaKomoditiController::class, 'preview'])->name('riwayat_harga_komoditi.peview');
    // Route untuk import dan export data kategori
    Route::post('kategori/import', [KategoriController::class, 'import'])->name('kategori.import')->middleware(['auth', 'admin']);
    Route::get('/kategori_export', [KategoriController::class, 'export'])->name('kategori.export');
    Route::get('/kategori_preview', [KategoriController::class, 'preview'])->name('kategori.preview');
    // Route untuk import dan export data produk komoditi
    Route::post('produk_komoditi/import', [ProdukKomoditiController::class, 'import'])->name('produk_komoditi.import')->middleware(['auth', 'admin']);
    Route::get('/produk_export', [ProdukKomoditiController::class, 'export'])->name('produk_komoditi.export');
    Route::get('/produk_preview', [ProdukKomoditiController::class, 'preview'])->name('produk_komoditi.preview');
    // Route untuk import dan export data komoditi
    Route::post('komoditi/import', [KomoditiController::class, 'import'])->name('komoditi.import')->middleware(['auth', 'admin']);
    Route::get('/komoditi_export', [KomoditiController::class, 'export'])->name('komoditi.export');
    Route::get('/komoditi_preview', [KomoditiController::class, 'preview'])->name('komoditi.preview');
});

require __DIR__.'/auth.php';