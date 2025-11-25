<?php

namespace App\Models;

use App\Traits\HasCustomId;
use Illuminate\Database\Eloquent\Model;

class Rekening extends Model
{
    use HasCustomId;
    
    protected $table = 'rekenings';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function getCustomIdPrefix(): string
    {
        return 'REK';
    }

    protected $fillable = [
        'id',
        'nama_bank',
        'nomor_rekening',
        'atas_nama',
        'logo',
        'is_active',
    ];
}
