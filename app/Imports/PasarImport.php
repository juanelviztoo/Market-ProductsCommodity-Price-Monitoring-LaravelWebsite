<?php

namespace App\Imports;

use App\Models\Pasar;
// use Illuminate\Support\Collection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PasarImport implements ToModel, WithHeadingRow
{
    public $rowCount = 0;
    public $importedPasarNames = [];

    public function model(array $row)
    {
        $gambar_pasar = null;
        if (!empty($row['gambar_pasar'])) {
            $file_name = basename($row['gambar_pasar']);
            $unique_file_name = Str::random(10) . '_' . $file_name;

            $image_content = file_get_contents($row['gambar_pasar']);
            if ($image_content !== false) {
                Storage::put('public/gambar_pasar/' . $unique_file_name, $image_content);
                $gambar_pasar = $unique_file_name;
            } else {
                throw new \Exception('Failed to download image: ' . $row['gambar_pasar']);
            }
        }

        $this->rowCount++;
        $this->importedPasarNames[] = $row['nama_pasar'];

        return new Pasar([
            'provinsi' => $row['provinsi'],
            'kota' => $row['kota'],
            'kode_kota' => $row['kode_kota'],
            'nama_pasar' => $row['nama_pasar'],
            'gambar_pasar' => $gambar_pasar,
        ]);
    }
}