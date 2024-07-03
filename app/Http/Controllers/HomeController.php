<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\RiwayatHargaKomoditi;
use App\Models\ProdukKomoditi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Load categories with their commodities and price history, sorted by date
        $kategoris = Kategori::with(['komoditi.riwayatHargaKomoditi' => function($query) {
            $query->orderBy('tanggal_update', 'desc');
        }, 'komoditi.produkKomoditi'])->get();

        // Prepare data for view
        $kategoris->each(function($kategori) {
            $kategori->komoditi->each(function($komoditi) {
                // Mengambil harga terbaru dan sebelumnya dari semua pasar
                $latestPrices = $komoditi->riwayatHargaKomoditi->groupBy('pasar_id')->map(function($prices) {
                    return $prices->first()->harga;
                });

                $previousPrices = $komoditi->riwayatHargaKomoditi->groupBy('pasar_id')->map(function($prices) {
                    return $prices->skip(1)->first()->harga ?? null;
                })->filter();

                // Menghitung rerata harga terbaru dan sebelumnya
                $latestAveragePrice = $latestPrices->avg();
                $previousAveragePrice = $previousPrices->avg();

                // Menghitung selisih harga dan perubahan persentase
                $priceDiff = $latestAveragePrice - $previousAveragePrice;
                $percentageChange = $previousAveragePrice ? ($priceDiff / $previousAveragePrice) * 100 : 0;
                $percentageChange = round($percentageChange, 2);

                // Menentukan status harga berdasarkan perubahan harga
                if ($priceDiff > 0) {
                    $status = 'Harga Naik';
                    $statusClass = 'badge badge-danger';
                    $statusIcon = 'fas fa-arrow-up';
                } elseif ($priceDiff < 0) {
                    $status = 'Harga Turun';
                    $statusClass = 'badge badge-success';
                    $statusIcon = 'fas fa-arrow-down';
                } else {
                    $status = 'Harga Tetap';
                    $statusClass = 'badge badge-warning';
                    $statusIcon = 'fas fa-star';
                }

                // Mengambil satuan dari produk komoditi
                $satuan = optional($komoditi->produkKomoditi->first())->satuan ?? '';

                // Menyimpan hasil perhitungan dalam properti komoditi
                $komoditi->latestAveragePrice = $latestAveragePrice;
                $komoditi->priceDiff = $priceDiff;
                $komoditi->percentageChange = $percentageChange;
                $komoditi->status = $status;
                $komoditi->statusClass = $statusClass;
                $komoditi->statusIcon = $statusIcon;
                $komoditi->satuan = $satuan;
            });
        });

        return view('home', compact('kategoris'));
    }
}
