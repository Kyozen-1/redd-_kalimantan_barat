<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PivotKategoriDokumen extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function md_kategori_dokumen()
    {
        return $this->belongsTo('App\Models\MdKategoriDokumen', 'kategori_id');
    }

    public function dokumen_galeri()
    {
        return $this->belongsTo('App\Models\DokumenGaleri', 'dokumen_id');
    }
}
