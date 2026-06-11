<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'regencies';
    protected $guarded = 'id';

    public function md_lsm()
    {
        return $this->hasMany('App\Models\MdLsm', 'kabupaten_kota_id');
    }

    public function galeri()
    {
        return $this->hasMany('App\Models\Galeri', 'kabupaten_kota_id');
    }
}
