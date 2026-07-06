<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdKawasanHutan extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function data_kawasan()
    {
        return $this->hasMany('App\Models\DataKawasan', 'kawasan_hutan_id');
    }
}
