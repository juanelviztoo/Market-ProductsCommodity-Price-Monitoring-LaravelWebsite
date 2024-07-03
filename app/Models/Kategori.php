<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = ['nama_kategori'];

    public function komoditi()
    {
        return $this->hasMany(Komoditi::class);
    }

    // Implement model event to handle cascading delete manually if needed
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($kategori) {
            $kategori->komoditi()->each(function($komoditi) {
                $komoditi->delete();
            });
        });
    }
}
