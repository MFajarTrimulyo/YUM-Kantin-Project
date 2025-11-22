<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produk extends Model
{
    use HasCustomId;
    
    protected $table = 'produks';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'slug',
        'photo',
        'nama',
        'deskripsi',
        'pilihan_rasa',
        'harga',
        'harga_diskon',
        'fk_kategori',
        'fk_gerai',
        'stok',
        'terjual'
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->slug = Str::slug($model->nama);
        });
    }
    
    public function getCustomIdPrefix(): string
    {
        return 'PRD';
    }

    public function kategori() {
        return $this->belongsTo(Kategori::class, 'fk_kategori');
    }
    
    public function gerai() {
        return $this->belongsTo(Gerai::class, 'fk_gerai');
    }
}
