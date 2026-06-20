<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdWilayahCakupan extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function md_lsm()
    {
        return $this->hasMany('App\Models\MdLsm', 'md_wilayah_cakupan_id');
    }
}
