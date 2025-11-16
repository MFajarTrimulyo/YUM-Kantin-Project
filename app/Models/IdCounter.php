<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdCounter extends Model
{
    protected $table = 'id_counters';
    public $timestamps = false;

    protected $fillable = [
        'table_name',
        'year_suffix',
        'last_number',
    ];
}