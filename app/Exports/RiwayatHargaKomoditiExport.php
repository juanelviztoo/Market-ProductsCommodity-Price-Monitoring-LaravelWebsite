<?php

namespace App\Exports;

use App\Models\RiwayatHargaKomoditi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;

class RiwayatHargaKomoditiExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping, WithStyles, WithEvents
{
    public function collection()
    {
        return RiwayatHargaKomoditi::with(['pasar', 'komoditi', 'produkKomoditi'])->get();
    }

    public function headings(): array
    {
        return [
            'Pasar', 'Jenis Komoditi', 'Produk Komoditi', 'Tanggal Update', 'Harga', 'Status'
        ];
    }

    public function map($row): array
    {
        return [
            $row->pasar->nama_pasar ?? 'N/A',
            $row->komoditi->jenis_komoditi ?? 'N/A',
            $row->produkKomoditi->nama_produk ?? 'N/A',
            $row->tanggal_update,
            $row->harga,
            $row->status,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 20,
            'C' => 30,
            'D' => 20,
            'E' => 15,
            'F' => 15,
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