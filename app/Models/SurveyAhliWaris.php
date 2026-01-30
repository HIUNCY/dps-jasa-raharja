<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyAhliWaris extends Model
{
    use SoftDeletes;

    protected $table = 'survey_ahli_waris';
    protected $guarded = ['id'];
    protected $casts = [
        'tanggal_survey' => 'date',
    ];

    public function korban()
    {
        return $this->belongsTo(Korban::class, 'korban_id');
    }

    public function surveyor()
    {
        return $this->belongsTo(User::class, 'petugas_survey_id');
    }
}
