<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class PivotGambarBerita extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function berita()
    {
        return $this->belongsTo('App\Models\Berita', 'berita_id');
    }

    public function getGambarUrlAttribute()
    {
        return Storage::disk('s3')->url($this->image_path);
    }
}
