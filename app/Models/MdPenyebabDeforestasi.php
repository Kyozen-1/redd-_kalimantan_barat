<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdPenyebabDeforestasi extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function data_deforestasi()
    {
        return $this->hasMany('App\Models\DataDeforestasi', 'penyebab_deforestasi_id');
    }
}
