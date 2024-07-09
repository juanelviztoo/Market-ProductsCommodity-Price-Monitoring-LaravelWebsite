<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\RiwayatHargaKomoditi;
use App\Models\ProdukKomoditi;
use App\Models\Pasar;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        // QUERY 1
        $kategoris = Kategori::with(['komoditi.riwayatHargaKomoditi' => function($query) {
            $query->orderBy('tanggal_update', 'desc');
        }, 'komoditi.produkKomoditi.riwayatHargaKomoditi' => function($query) {
            $query->orderBy('tanggal_update', 'desc');
        }])->get();

        // Prepare data for view
        $kategoris->each(function($kategori) {
            $kategori->komoditi->each(function($komoditi) {
                // Group prices by market for komoditi
                $groupedPrices = $komoditi->riwayatHargaKomoditi->groupBy('pasar_id');

                // Calculate latest and previous average prices for komoditi
                $latestPrices = $groupedPrices->map(fn($prices) => $prices->first()->harga);
                $previousPrices = $groupedPrices->map(fn($prices) => $prices->skip(1)->first()->harga ?? null)->filter();

                $latestAveragePrice = $latestPrices->avg();
                $previousAveragePrice = $previousPrices->avg();
                $priceDiff = $latestAveragePrice - $previousAveragePrice;
                $percentageChange = $previousAveragePrice ? ($priceDiff / $previousAveragePrice) * 100 : 0;
                $percentageChange = round($percentageChange, 2);

                // Determine status for komoditi
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

                // Store calculated data for komoditi
                $komoditi->latestAveragePrice = $latestAveragePrice;
                $komoditi->priceDiff = $priceDiff;
                $komoditi->percentageChange = $percentageChange;
                $komoditi->status = $status;
                $komoditi->statusClass = $statusClass;
                $komoditi->statusIcon = $statusIcon;
                $komoditi->satuan = $satuan;

                // Group prices by market for product komoditi
                $komoditi->produkKomoditi->each(function($produkKomoditi) {
                    $groupedPrices = $produkKomoditi->riwayatHargaKomoditi->groupBy('pasar_id');

                    // Calculate latest and previous average prices for product komoditi
                    $latestPrices = $groupedPrices->map(fn($prices) => $prices->first()->harga);
                    $previousPrices = $groupedPrices->map(fn($prices) => $prices->skip(1)->first()->harga ?? null)->filter();

                    $latestAveragePrice = $latestPrices->avg();
                    $previousAveragePrice = $previousPrices->avg();
                    $priceDiff = $latestAveragePrice - $previousAveragePrice;
                    $percentageChange = $previousAveragePrice ? ($priceDiff / $previousAveragePrice) * 100 : 0;
                    $percentageChange = round($percentageChange, 2);

                    // Determine status for product komoditi
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

                    // Store calculated data for product komoditi
                    $produkKomoditi->latestAveragePrice = $latestAveragePrice;
                    $produkKomoditi->priceDiff = $priceDiff;
                    $produkKomoditi->percentageChange = $percentageChange;
                    $produkKomoditi->status = $status;
                    $produkKomoditi->statusClass = $statusClass;
                    $produkKomoditi->statusIcon = $statusIcon;
                });
            });
        });

        // QUERY 2: Fetching product commodities and their price history
        $produkKomoditis = ProdukKomoditi::with(['riwayatHargaKomoditi.pasar'])->get();

        // Prepare data for view
        $produkKomoditis->each(function($produkKomoditi) {
            // Group prices by market for each product commodity
            $groupedPrices = $produkKomoditi->riwayatHargaKomoditi->groupBy('pasar_id');

            // Initialize highest and lowest price variables
            $highestPrice = null;
            $lowestPrice = null;

            // Loop through grouped prices to find the highest and lowest prices across all markets
            foreach ($groupedPrices as $prices) {
                $prices->each(function ($price) use (&$highestPrice, &$lowestPrice) {
                    if (is_null($highestPrice) || $price->harga > $highestPrice) {
                        $highestPrice = $price->harga;
                    }
                    if (is_null($lowestPrice) || $price->harga < $lowestPrice) {
                        $lowestPrice = $price->harga;
                    }
                });
            }

            // Get the latest and previous prices for each market, sorted by date
            $latestPrices = $groupedPrices->map(function($prices) {
                return $prices->sortByDesc('tanggal_update')->first()->harga;
            });
            $previousPrices = $groupedPrices->map(function($prices) {
                return $prices->sortByDesc('tanggal_update')->skip(1)->first()->harga ?? null;
            })->filter();

            // Calculate latest and previous average prices across all markets
            $latestPrice = $latestPrices->first();
            $previousPrice = $previousPrices->first();

            // Calculate price difference and percentage change
            $priceDiff = $latestPrice - $previousPrice;
            $percentageChange = $previousPrice ? ($priceDiff / $previousPrice) * 100 : 0;
            $percentageChange = round($percentageChange, 2);

            // Determine status for product komoditi
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

            // Store calculated data for product komoditi
            $produkKomoditi->highestPrice = $highestPrice;
            $produkKomoditi->lowestPrice = $lowestPrice;
            $produkKomoditi->latestPrice = $latestPrice;
            $produkKomoditi->priceDiff = $priceDiff;
            $produkKomoditi->percentageChange = $percentageChange;
            $produkKomoditi->status = $status;
            $produkKomoditi->statusClass = $statusClass;
            $produkKomoditi->statusIcon = $statusIcon;
            $produkKomoditi->groupedPrices = $groupedPrices;
        });

        return view('home', compact('kategoris', 'produkKomoditis'));
    }
}