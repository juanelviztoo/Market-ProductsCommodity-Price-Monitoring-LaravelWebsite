<?php

namespace App\Imports;

use App\Models\Komoditi;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithValidation;
// use Illuminate\Support\Facades\Log;

class KomoditiImport implements ToModel, WithHeadingRow
{
    private $rowCount = 0;
    private $importedJenis = [];

    public function model(array $row)
    {
        $kategori = Kategori::where('nama_kategori', $row['nama_kategori'])->first();

        if (!$kategori) {
            return null;
        }

        // Menyimpan gambar komoditi dari link
        $gambarKomoditi = null;
        if (isset($row['gambar_komoditi']) && filter_var($row['gambar_komoditi'], FILTER_VALIDATE_URL)) {
            $imageContents = file_get_contents($row['gambar_komoditi']);
            $imageName = basename(parse_url($row['gambar_komoditi'], PHP_URL_PATH));
            Storage::put('public/gambar_komoditi/' . $imageName, $imageContents);
            $gambarKomoditi = $imageName;
        }

        Komoditi::create([
            'kategori_id' => $kategori->id,
            'jenis_komoditi' => $row['jenis_komoditi'],
            'gambar_komoditi' => $gambarKomoditi,
        ]);

        $this->rowCount++;
        $this->importedJenis[] = $row['jenis_komoditi'];
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function getImportedJenis()
    {
        return $this->importedJenis;
    }
}
