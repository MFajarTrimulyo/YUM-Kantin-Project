<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    protected $table = 'kantins';
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
    ];

    public function gerais() {
        return $this->hasMany(Gerai::class, 'fk_kantin');
    }
}
