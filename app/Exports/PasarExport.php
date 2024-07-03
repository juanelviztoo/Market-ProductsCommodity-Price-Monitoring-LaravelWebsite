<?php

namespace App\Exports;

use App\Models\Pasar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class PasarExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, WithColumnWidths
{
    public function collection()
    {
        return Pasar::select( 'provinsi', 'kota' , 'kode_kota', 'nama_pasar')->get(); //buat nyambung ke database(harus sama)
    }

    public function headings(): array
    {
        return [
            'provinsi', 'kota' , 'kode kota', 'nama pasar', 'gambar pasar' //ubah2 terserah(nama heading di excel)
        ];
    }

    public function map($produk): array
    {
        // Move satuan to the right by adding a placeholder before it
        return [
            $produk->provinsi, 
            $produk->kota,
            $produk->kode_kota,
            $produk->nama_pasar,
            '', // Placeholder for the image
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $products = Pasar::all();

        foreach ($products as $index => $product) {
            if ($product->gambar_pasar) {
                $drawing = new Drawing();
                $drawing->setName($product->nama_pasar);
                $drawing->setDescription($product->nama_pasar);
                $drawing->setPath(public_path('storage/gambar_pasar/' . $product->gambar_pasar));
                $drawing->setHeight(20);
                $drawing->setCoordinates('E' . ($index + 2));

                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }

    // Adjust the column table's widht with to make it neat
    public function columnWidths(): array
    {
        return [
            'A' => 10,  //ngatur lebar kolom (px)
            'B' => 20,
            'C' => 20,
            'D' => 15,
            'E' => 30,
            'F' => 50,
        ];
    }
}