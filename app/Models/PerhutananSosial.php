<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PerhutananSosial extends Model
{
    protected $table = 'perhutanan_sosials';

    protected $fillable = [
        'nama_desa',
        'kabupaten_kota_id',
        'skema',
        'nama_lembaga',
        'nomor_sk',
        'status_aktif',
    ];

    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function kabupaten_kota()
    {
        return $this->belongsTo('App\Models\Regency', 'kabupaten_kota_id');
    }
}
