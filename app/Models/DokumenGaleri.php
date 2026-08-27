<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Crypt;

class DokumenGaleri extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function pivot_kategori_dokumen()
    {
        return $this->hasMany('App\Models\PivotKategoriDokumen', 'dokumen_id');
    }

    public function getExcelUrlAttribute()
    {
        if (!$this->document_file_excel_path) {
            return null;
        }

        return route('cms.dokumen-galeri.file', [
            'id' => Crypt::encryptString($this->id),
            'type' => 'excel',
        ]);
    }

    public function getPdfUrlAttribute()
    {
        if (!$this->document_file_pdf_path) {
            return null;
        }

        return route('cms.dokumen-galeri.file', [
            'id' => Crypt::encryptString($this->id),
            'type' => 'pdf',
        ]);
    }

    public function getWordUrlAttribute()
    {
        if (!$this->document_file_word_path) {
            return null;
        }

        return route('cms.dokumen-galeri.file', [
            'id' => Crypt::encryptString($this->id),
            'type' => 'word',
        ]);
    }
}
