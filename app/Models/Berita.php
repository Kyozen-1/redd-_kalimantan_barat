<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Berita extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function pivot_gambar_berita()
    {
        $this->hasMany('App\Models\PivotGambarBerita', 'berita_id');
    }
}
