<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $fillable = ['email', 'pesan', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
