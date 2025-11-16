<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class Gerai extends Model
{
    use HasCustomId;
    
    protected $table = 'gerais';
    public $incrementing = false;
    protected $keyType = 'char';

    public function getCustomIdPrefix(): string
    {
        return 'GRI';
    }

    // Relasi ke Produk
    public function produks() {
        return $this->hasMany(Produk::class, 'fk_gerai');
    }

    // Relasi ke Pemesanan
    public function pemesanans() {
        return $this->hasMany(Pemesanan::class, 'fk_gerai');
    }
}
