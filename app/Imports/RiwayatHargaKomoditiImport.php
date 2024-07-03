<?php

namespace App\Imports;

use App\Models\RiwayatHargaKomoditi;
use App\Models\Pasar;
use App\Models\Komoditi;
use App\Models\ProdukKomoditi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class RiwayatHargaKomoditiImport implements ToModel, WithHeadingRow
{
    private $rowCount = 0;
    private $importedProdukKomoditis = [];
    private $statuses = [];

    public function model(array $row)
    {
        // Convert Excel date value to PHP date format
        if (is_numeric($row['tanggal_update'])) {
            $row['tanggal_update'] = Date::excelToDateTimeObject($row['tanggal_update'])->format('Y-m-d');
        }

        // Get the IDs based on the names
        $pasar = Pasar::where('nama_pasar', $row['nama_pasar'])->first();
        $komoditi = Komoditi::where('jenis_komoditi', $row['jenis_komoditi'])->first();
        $produkKomoditi = ProdukKomoditi::where('nama_produk', $row['nama_produk'])->first();

        $this->rowCount++;
        $this->importedProdukKomoditis[] = $row['nama_produk'];
        $this->statuses[] = $row['status'];

        return new RiwayatHargaKomoditi([
            'pasar_id' => $pasar ? $pasar->id : null,
            'komoditi_id' => $komoditi ? $komoditi->id : null,
            'produk_komoditi_id' => $produkKomoditi ? $produkKomoditi->id : null,
            'tanggal_update' => $row['tanggal_update'],
            'harga' => $row['harga'],
            'status' => $row['status'],
        ]);
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getImportedProdukKomoditis()
    {
        return $this->importedProdukKomoditis;
    }

    public function getStatuses()
    {
        return $this->statuses;
    }
}

