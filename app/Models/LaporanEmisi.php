<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class LaporanEmisi extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function getExcelUrlAttribute()
    {
        return Storage::disk('s3')->url($this->document_file_excel_path);
    }

    public function getPdfUrlAttribute()
    {
        return Storage::disk('s3')->url($this->document_file_pdf_path);
    }

    public function getWordUrlAttribute()
    {
        return Storage::disk('s3')->url($this->document_file_word_path);
    }
}
