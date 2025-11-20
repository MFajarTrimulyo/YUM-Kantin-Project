<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasCustomId;
    
    protected $table = 'pemesanan';
    public $incrementing = false;
    protected $keyType = 'char';

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
