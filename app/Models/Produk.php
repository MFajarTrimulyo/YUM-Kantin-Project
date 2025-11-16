<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasCustomId;
    
    protected $table = 'produks';
    public $incrementing = false;
    protected $keyType = 'char';

    public function getCustomIdPrefix(): string
    {
        return 'PRD';
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'fk_kategori');
    }
    
    public function gerais() {
        return $this->belongsTo(Gerai::class, 'fk_gerai');
    }
}
