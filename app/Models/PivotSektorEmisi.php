<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PivotSektorEmisi extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function emisi()
    {
        return $this->belongsTo('App\Models\MdEmisi', 'emisi_id');
    }

    public function sektor_emisi()
    {
        return $this->belongsTo('App\Models\MdSektorEmisi', 'sektor_emisi_id');
    }

    public function data_emisi()
    {
        return $this->hasMany('App\Models\DataEmisi', 'pivot_sektor_emisi_id');
    }
}
