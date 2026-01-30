<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterStatusSaksiPeristiwa extends Model
{
    use SoftDeletes;

    protected $table = 'master_status_saksi_peristiwa';
    protected $guarded = ['id'];
}
