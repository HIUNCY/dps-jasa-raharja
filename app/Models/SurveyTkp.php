<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyTkp extends Model
{
    use SoftDeletes;

    protected $table = 'survey_tkp';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_survey' => 'date',
    ];

    public function kasus()
    {
        return $this->belongsTo(KasusKecelakaan::class, 'kasus_kecelakaan_id');
    }

    public function surveyor()
    {
        return $this->belongsTo(User::class, 'petugas_survey_id');
    }

    public function korban()
    {
        return $this->belongsTo(Korban::class, 'korban_id');
    }
}
