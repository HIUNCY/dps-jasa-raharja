<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterStatusKeterjaminan extends Model
{
    use SoftDeletes;

    protected $table = 'master_status_keterjaminan';
    protected $guarded = ['id'];
}
