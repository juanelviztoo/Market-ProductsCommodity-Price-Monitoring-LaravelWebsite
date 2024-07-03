<?php

namespace App\Imports;

use App\Models\ProdukKomoditi;
use App\Models\Komoditi;
// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
// use Maatwebsite\Excel\Concerns\Importable;
// use Maatwebsite\Excel\Concerns\WithValidation;
// use Maatwebsite\Excel\Concerns\WithBatchInserts;
// use Maatwebsite\Excel\Concerns\WithChunkReading;
// use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class ProdukKomoditiImport implements OnEachRow, WithHeadingRow
{
    private $rowCount = 0;
    private $importedNames = [];

    public function onRow(Row $row)
    {
        $row = $row->toArray();

        // Mengambil id komoditi berdasarkan jenis_komoditi
        $komoditi = Komoditi::where('jenis_komoditi', $row['jenis_komoditi'])->first();

        if (!$komoditi) {
            return null;
        }

        // Menyimpan gambar produk dari link
        $gambarProduk = null;
        if (isset($row['gambar_produk']) && filter_var($row['gambar_produk'], FILTER_VALIDATE_URL)) {
            $imageContents = file_get_contents($row['gambar_produk']);
            $imageName = basename(parse_url($row['gambar_produk'], PHP_URL_PATH));
            Storage::put('public/gambar_produk/' . $imageName, $imageContents);
            $gambarProduk = $imageName;
        }

        ProdukKomoditi::create([
            'komoditi_id' => $komoditi->id,
            'nama_produk' => $row['nama_produk'],
            'gambar_produk' => $gambarProduk,
            'satuan' => $row['satuan'],
        ]);

        // Meningkatkan jumlah baris yang diimpor
        $this->rowCount++;
        // Menambahkan nama produk ke array
        $this->importedNames[] = $row['nama_produk'];
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getImportedNames()
    {
        return $this->importedNames;
    }
}
