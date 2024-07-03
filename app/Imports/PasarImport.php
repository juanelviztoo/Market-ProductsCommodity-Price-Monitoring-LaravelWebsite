<?php

namespace App\Imports;

use App\Models\Pasar;
// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class PasarImport implements ToModel, WithHeadingRow
{
    private $importedPasars = [];

    public function model(array $row)
    {
        // Download gambar dari URL
        $imageName = null;
        if (!empty($row['gambar_pasar'])) {
            $imageUrl = $row['gambar_pasar'];
            try {
                $response = Http::get($imageUrl);
                if ($response->successful()) {
                    $imageContents = $response->body();
                    $imageName = basename($imageUrl);
                    Storage::put('public/gambar_pasar/' . $imageName, $imageContents);
                } else {
                    // Jika gambar tidak dapat diambil, beri nama default
                    $imageName = 'default.png';
                }
            } catch (\Exception $e) {
                // Jika ada kesalahan saat mengambil gambar, beri nama default
                $imageName = 'default.png';
            }
        }

        $pasar = Pasar::create([
            'provinsi' => $row['provinsi'],
            'kota' => $row['kota'],
            'kode_kota' => $row['kode_kota'],
            'nama_pasar' => $row['nama_pasar'],
            'gambar_pasar' => $imageName,
        ]);

        $this->importedPasars[] = $pasar->nama_pasar;

        return $pasar;
    }

    public function getImportedPasars()
    {
        return $this->importedPasars;
    }
}