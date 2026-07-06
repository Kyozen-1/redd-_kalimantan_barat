<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdSektorEmisi extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function pivot_sektor_emisi()
    {
        return $this->hasMany('App\Models\PivotSektorEmisi', 'sektor_emisi_id');
    }
}
