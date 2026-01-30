<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterAsalKorban extends Model
{
    use SoftDeletes;

    protected $table = 'master_asal_korban';
    protected $guarded = ['id'];
}
