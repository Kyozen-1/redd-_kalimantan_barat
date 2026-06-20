<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class LandingPageSection extends Model
{
    protected $casts = [
        'content' => 'array',
    ];

    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function section()
    {
        return $this->belongsTo('App\Models\MdSectionLandingPage', 'section_id');
    }
}
