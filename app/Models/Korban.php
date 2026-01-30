<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Korban extends Model
{
    use SoftDeletes;

    protected $table = 'korban';
    protected $guarded = ['id'];
    protected $casts = [
        'waktu_masuk_rs' => 'datetime',
        'is_survey_tkp' => 'boolean',
        'is_survey_ahli_waris' => 'boolean',
        'is_meninggal' => 'boolean',
    ];

    public function kasus()
    {
        return $this->belongsTo(KasusKecelakaan::class, 'kasus_kecelakaan_id');
    }

    public function loket()
    {
        return $this->belongsTo(MasterLoket::class, 'loket_id');
    }

    public function profesi()
    {
        return $this->belongsTo(MasterProfesi::class, 'profesi_id');
    }

    public function statusKorban()
    {
        return $this->belongsTo(MasterStatusKorban::class, 'status_korban_id');
    }

    public function statusKeterjaminan()
    {
        return $this->belongsTo(MasterStatusKeterjaminan::class, 'status_keterjaminan_id');
    }

    public function surveyAhliWaris()
    {
        return $this->hasOne(SurveyAhliWaris::class, 'korban_id');
    }
}
