<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komoditi extends Model
{
    use HasFactory;

    protected $table = 'komoditi';

    protected $fillable = ['kategori_id', 'jenis_komoditi', 'gambar_komoditi'];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function riwayatHargaKomoditi()
    {
        return $this->hasMany(RiwayatHargaKomoditi::class);
    }

    public function produkKomoditi()
    {
        return $this->hasMany(ProdukKomoditi::class);
    }

    // Implement model event to handle cascading delete manually if needed
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($komoditi) {
            $komoditi->riwayatHargaKomoditi()->delete();
            $komoditi->produkKomoditi()->delete();
        });
    }
}
