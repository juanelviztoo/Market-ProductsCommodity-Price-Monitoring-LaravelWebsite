<?php

namespace App\Imports;

use App\Models\Pasar;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PasarImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Menggunakan timestamp untuk membuat nama file unik
        $imageName = 'gambar_pasar/' . time() . '_' . $row['gambar_pasar'];

        // Pindahkan gambar ke storage
        if ($row['gambar_pasar']) {
            Storage::disk('public')->put($imageName, base64_decode($row['gambar_pasar']));
        }

        return new Pasar([
            'provinsi' => $row['provinsi'],
            'kota' => $row['kota'],
            'kode_kota' => $row['kode_kota'],
            'nama_pasar' => $row['nama_pasar'],
            'gambar_pasar' => $imageName,
        ]);
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}