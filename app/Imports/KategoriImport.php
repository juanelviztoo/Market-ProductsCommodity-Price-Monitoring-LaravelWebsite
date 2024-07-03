<?php

namespace App\Imports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KategoriImport implements ToModel, WithHeadingRow
{
    public $importedCount = 0;
    public $importedNames = [];

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->importedCount++;
        $this->importedNames[] = $row['nama_kategori'];

        return new Kategori([
            'nama_kategori' => $row['nama_kategori'],
        ]);
    }
}
