<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;

class DokumenRad extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function getDocumentUrlAttribute()
    {
        return route('cms.dokumen-rad.file', [
            'id' => Crypt::encryptString($this->id),
        ]);
    }
}
