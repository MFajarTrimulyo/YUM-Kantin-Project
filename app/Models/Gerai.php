<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Gerai extends Model
{
    use HasCustomId;
    
    protected $table = 'gerais';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'slug',
        'photo',
        'fk_user',
        'fk_kantin',
        'nama',
        'deskripsi',
        'is_open',
        'is_verified',
    ];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $kantin = Kantin::find($model->fk_kantin);
            $namaKantin = $kantin ? $kantin->nama_kantin : '';

            $originalSlug = Str::slug($model->nama . ' ' . $namaKantin);
            $slug = $originalSlug;
            $count = 1;

            while (static::where('slug', $slug)->where('id', '!=', $model->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }

            $model->slug = $slug;
        });
    }

    public function getCustomIdPrefix(): string
    {
        return 'GRI';
    }

    // Relasi ke User
    public function user() {
        return $this->belongsTo(User::class, 'fk_user');
    }

    // Relasi ke Kantin
    public function kantin() {
        return $this->belongsTo(Kantin::class, 'fk_kantin');
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
