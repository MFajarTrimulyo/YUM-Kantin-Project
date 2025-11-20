<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
        use HasCustomId;
    
    protected $table = 'kategoris';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
    ];

    public function getCustomIdPrefix(): string
    {
        return 'KTG';
    }

    public function produks() {
        return $this->hasMany(Produk::class, 'fk_kategori');
    }
}
