<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdEmisi extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function pivot_sektor_emisi()
    {
        return $this->hasMany('App\Models\PivotSektorEmisi', 'emisi_id');
    }
}
