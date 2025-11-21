<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class DetailPemesanan extends Model
{
    use HasCustomId;
    
    protected $table = 'detail_pemesanans';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'fk_order',
        'fk_produk',
        'qty',
        'harga_satuan_saat_beli',
        'catatan'
    ];

    public function getCustomIdPrefix(): string
    {
        return 'DTL';
    }

    // Relasi balik ke Produk untuk ambil nama/gambar
    public function produk() {
        return $this->belongsTo(Produk::class, 'fk_produk');
    }
}
