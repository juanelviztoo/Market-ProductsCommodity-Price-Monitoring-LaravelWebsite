<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use App\Models\ProdukKomoditi;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ProdukKomoditiExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, WithColumnWidths
{
    public function collection()
    {
        return ProdukKomoditi::with('komoditi')->select('id', 'komoditi_id', 'nama_produk', 'gambar_produk', 'satuan')->get();
    }

    public function headings(): array
    {
        return [
            'Jenis Komoditi', 'Nama Produk', 'Gambar Produk', 'Satuan'
        ];
    }

    public function map($produk): array
    {
        return [
            $produk->komoditi->jenis_komoditi ?? 'N/A',
            $produk->nama_produk,
            '', // Placeholder for the image
            $produk->satuan,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $products = ProdukKomoditi::all();

        foreach ($products as $index => $product) {
            if ($product->gambar_produk) {
                $drawing = new Drawing();
                $drawing->setName($product->nama_produk);
                $drawing->setDescription($product->nama_produk);
                $drawing->setPath(public_path('storage/gambar_produk/' . $product->gambar_produk));
                $drawing->setHeight(20);
                // $drawing->setWidth(50); 
                $drawing->setCoordinates('C' . ($index + 2)); // 'C' is the 3rd column for 'Gambar Produk'

                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // Jenis Komoditi
            'B' => 30, // Nama Produk
            'C' => 50, // Gambar Produk
            'D' => 15, // Satuan
        ];
    }
}