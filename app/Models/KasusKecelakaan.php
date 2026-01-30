<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KasusKecelakaan extends Model
{
    use SoftDeletes;

    protected $table = 'kasus_kecelakaan';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_kejadian' => 'datetime',
        'tanggal_laporan_polisi' => 'date',
    ];

    public function loket()
    {
        return $this->belongsTo(MasterLoket::class, 'loket_id');
    }

    public function kasusLaka()
    {
        return $this->belongsTo(MasterKasusLaka::class, 'kasus_laka_id');
    }

    public function korbans()
    {
        return $this->hasMany(Korban::class, 'kasus_kecelakaan_id');
    }

    public function kendaraans()
    {
        return $this->belongsToMany(Kendaraan::class, 'kasus_kendaraan')
                    ->withPivot('peran', 'keterangan')
                    ->withTimestamps();
    }

    public function surveyTkp()
    {
        return $this->hasOne(SurveyTkp::class, 'kasus_kecelakaan_id');
    }
}
