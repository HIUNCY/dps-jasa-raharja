<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterHubunganKorban extends Model
{
    use SoftDeletes;

    protected $table = 'master_hubungan_korban';
    protected $guarded = ['id'];
}
