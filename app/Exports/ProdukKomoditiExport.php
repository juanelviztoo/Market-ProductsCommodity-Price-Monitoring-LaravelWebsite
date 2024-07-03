<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use App\Models\ProdukKomoditi;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;

class ProdukKomoditiExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, WithColumnWidths, WithStyles, WithEvents
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

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'd4d4d8'], 
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ];

                // Apply borders to all cells with content
                $sheet->getStyle("A1:{$lastColumn}{$lastRow}")->applyFromArray($styleArray);

                // Auto-size columns
                foreach (range('A', $lastColumn) as $columnID) {
                    $sheet->getColumnDimension($columnID)->setAutoSize(true);
                }
            },
        ];
    }
}