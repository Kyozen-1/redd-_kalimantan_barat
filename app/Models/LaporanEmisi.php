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
        return Storage::disk('minio')->temporaryUrl($this->document_file_excel_path,
            now()->addMinutes(30));
    }

    public function getPdfUrlAttribute()
    {
        return Storage::disk('minio')->temporaryUrl(
            $this->document_file_pdf_path,
            now()->addMinutes(30)
        );
    }

    public function getWordUrlAttribute()
    {
        return Storage::disk('minio')->temporaryUrl($this->document_file_word_path,
            now()->addMinutes(30));
    }
}
