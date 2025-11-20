<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasCustomId;
    
    protected $table = 'pemesanan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'fk_user', 
        'fk_gerai', 
        'total_harga', 
        'status', 
        'status_bayar'
    ];

    public function getCustomIdPrefix(): string
    {
        return '#ORD-';
    }

    // Relasi ke Detail
    public function detail_pemesanans() {
        return $this->hasMany(DetailPemesanan::class, 'fk_order');
    }

    public function user() {
        return $this->belongsTo(User::class, 'fk_user');
    }
}
