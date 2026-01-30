<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterStatusKorban extends Model
{
    use SoftDeletes;

    protected $table = 'master_status_korban';
    protected $guarded = ['id'];
}
