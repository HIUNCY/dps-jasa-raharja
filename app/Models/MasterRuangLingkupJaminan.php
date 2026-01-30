<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRuangLingkupJaminan extends Model
{
    use SoftDeletes;

    protected $table = 'master_ruang_lingkup_jaminan';
    protected $guarded = ['id'];
}
