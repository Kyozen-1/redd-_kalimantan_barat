<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanMasyarakat extends Model
{
    protected $table = 'laporan_masyarakats';

    protected $fillable = [
        'laporan',
        'nama',
        'email',
        'ip_address',
        'status',
    ];
}
