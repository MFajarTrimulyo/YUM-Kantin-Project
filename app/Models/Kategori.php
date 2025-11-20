<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategoris';
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
    ];

    public function produks() {
        return $this->hasMany(Produk::class, 'fk_kategori');
    }
}
