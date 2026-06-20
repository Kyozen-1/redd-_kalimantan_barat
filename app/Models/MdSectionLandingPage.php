<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class MdSectionLandingPage extends Model
{
    public function scopeStatusAktif(Builder $query)
    {
        return $query->where('status_aktif', '1');
    }

    public function landing_page_section()
    {
        return $this->hasMany('App\Models\LandingPageSection', 'section_id');
    }
}
