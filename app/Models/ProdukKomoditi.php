<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukKomoditi extends Model
{
    use HasFactory;

    protected $table = 'produk_komoditi';

    protected $fillable = ['komoditi_id', 'nama_produk', 'gambar_produk', 'satuan'];

    public function komoditi()
    {
        return $this->belongsTo(Komoditi::class);
    }

    public function riwayatHargaKomoditi()
    {
        return $this->hasMany(RiwayatHargaKomoditi::class);
    }

    // Implement model event to handle cascading delete manually if needed
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($produkKomoditi) {
            $produkKomoditi->riwayatHargaKomoditi()->delete();
        });
    }
}
