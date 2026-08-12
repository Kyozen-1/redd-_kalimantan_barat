<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class DokumenRad extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function getDocumentUrlAttribute()
    {
        return Storage::disk('minio')->temporaryUrl($this->document_path,
            now()->addMinutes(30));
    }
}
