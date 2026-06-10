<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdKategoriDokumen extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function pivot_kategori_dokumen()
    {
        return $this->hasMany('App\Models\PivotKategoriDokumen', 'kategori_id');
    }
}
