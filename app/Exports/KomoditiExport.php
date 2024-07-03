<?php

namespace App\Exports;

use App\Models\Komoditi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;


class KomoditiExport implements FromCollection, WithHeadings, WithMapping, WithDrawings, WithColumnWidths, WithStyles, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Komoditi::select('kategori_id', 'jenis_komoditi')->get();
    }

    public function headings(): array
    {
        return [
            'Nama Kategori', 'Jenis Komoditi', 'Gambar Komoditi'
        ];
    }

    public function map($produk): array
    {
        // Move satuan to the right by adding a placeholder before it
        return [
            $produk->kategori->nama_kategori,
            $produk->jenis_komoditi,
            '', // Placeholder for the image
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $products = Komoditi::all();

        foreach ($products as $index => $product) {
            if ($product->gambar_komoditi) {
                $drawing = new Drawing();
                $drawing->setName($product->jenis_komoditi);
                $drawing->setDescription($product->jenis_komoditi);
                $drawing->setPath(public_path('storage\gambar_komoditi\\' . $product->gambar_komoditi));
                $drawing->setHeight(20);
                $drawing->setCoordinates('C' . ($index + 2));

                $drawings[] = $drawing;
            }
        }

        return $drawings;
    }

    // Adjust the column table's widht with to make it neat
    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20,
            'C' => 50,
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