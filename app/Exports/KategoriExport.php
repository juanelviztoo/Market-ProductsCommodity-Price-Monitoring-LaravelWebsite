<?php

namespace App\Exports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class KategoriExport implements FromCollection, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Menyesuaikan kolom yang akan diekspor
        return Kategori::all(['nama_kategori']);
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nama Kategori',
        ];
    }
}