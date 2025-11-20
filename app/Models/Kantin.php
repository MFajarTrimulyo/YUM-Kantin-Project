<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class Kantin extends Model
{
    use HasCustomId;
    
    protected $table = 'kantins';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
    ];

    public function getCustomIdPrefix(): string
    {
        return 'KNT';
    }

    public function gerais() {
        return $this->hasMany(Gerai::class, 'fk_kantin');
    }
}
