<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasar extends Model
{
    use HasFactory;

    protected $table = 'pasar';

    protected $fillable = ['provinsi', 'kota' , 'kode_kota', 'nama_pasar', 'gambar_pasar'];

    public function riwayatHarga()
    {
        return $this->hasMany(RiwayatHargaKomoditi::class);
    }

    // Implement model event to handle cascading delete manually if needed
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($pasar) {
            $pasar->riwayatHarga()->delete();
        });
    }
}
