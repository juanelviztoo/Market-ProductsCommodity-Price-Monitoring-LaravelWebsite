<?php

namespace App\Exports;

use App\Models\RiwayatHargaKomoditi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;

class RiwayatHargaKomoditiExport implements FromCollection, WithHeadings, WithColumnWidths, WithMapping
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
}