<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class DataKawasan extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function kawasan_hutan()
    {
        return $this->belongsTo('App\Models\MdKawasanHutan', 'kawasan_hutan_id');
    }
}
