<?php

namespace App\Imports;

use App\Models\ProdukKomoditi;
use App\Models\Komoditi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProdukKomoditiImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;
    public function model(array $row)
    {
        // Find komoditi by name
        $komoditi = Komoditi::where('jenis_komoditi', $row['jenis_komoditi'])->first();

        if (!$komoditi) {
            throw new \Exception('Komoditi with name ' . $row['jenis_komoditi'] . ' not found.');
        }

        // Handle image upload
        $gambar_produk = null;
        if (isset($row['gambar_produk']) && !empty($row['gambar_produk'])) {
            $imageData = $row['gambar_produk'];
            $imageName = time() . '_' . $row['nama_produk'] . '.png';
            Storage::put('public/gambar_produk/' . $imageName, base64_decode($imageData));
            $gambar_produk = $imageName;
        }

        return new ProdukKomoditi([
            'komoditi_id' => $komoditi->id,
            'nama_produk' => $row['nama_produk'],
            'gambar_produk' => $gambar_produk,
            'satuan' => $row['satuan'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.jenis_komoditi' => ['required', Rule::exists('komoditi', 'jenis_komoditi')],
            '*.nama_produk' => ['required', 'string'],
            '*.satuan' => ['required', 'string'],
        ];
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
