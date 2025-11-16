<?php

namespace App\Traits;

use App\Models\IdCounter;
use Illuminate\Support\Facades\DB;

trait HasCustomId
{
    /**
     * Boot trait ini secara otomatis saat model menggunakan trait ini.
     */
    public static function bootHasCustomId()
    {
        static::creating(function ($model) {
            // Panggil fungsi generate ID
            // $model->getKeyName() akan mengambil nama primary key (misal: 'id_pet')
            $model->{$model->getKeyName()} = self::generateCustomId($model);
        });
    }

    /**
     * Logika inti generate ID.
     */
    protected static function generateCustomId($model)
    {
        // Ambil konfigurasi dari model
        $prefix = $model->getCustomIdPrefix(); 
        $tableName = $model->getTable();       
        $suffixYear = date('y');       

        return DB::transaction(function () use ($prefix, $suffixYear, $tableName) {
            // 1. Lock baris counter
            $counter = IdCounter::where('table_name', $tableName)
                                ->where('year_suffix', $suffixYear)
                                ->lockForUpdate()
                                ->first();

            // 2. Buat baru jika belum ada
            if (!$counter) {
                $counter = IdCounter::create([
                    'table_name' => $tableName,
                    'year_suffix' => $suffixYear,
                    'last_number' => 0
                ]);
            }

            // 3. Increment
            $counter->increment('last_number');

            // 4. Format hasil akhir
            return $prefix . $suffixYear . str_pad($counter->last_number, 4, pad_string: '0', pad_type: STR_PAD_LEFT);
        });
    }
    abstract public function getCustomIdPrefix(): string;
}
