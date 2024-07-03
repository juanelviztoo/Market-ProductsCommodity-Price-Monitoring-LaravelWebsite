<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatHargaKomoditi extends Model
{
    use HasFactory;

    protected $table = 'riwayat_harga_komoditi';

    protected $fillable = [
        'pasar_id', 'komoditi_id', 'produk_komoditi_id',
        'tanggal_update', 'harga', 'status'
    ];

    public function pasar()
    {
        return $this->belongsTo(Pasar::class);
    }

    public function komoditi()
    {
        return $this->belongsTo(Komoditi::class);
    }

    public function produkKomoditi()
    {
        return $this->belongsTo(ProdukKomoditi::class);
    }
}
