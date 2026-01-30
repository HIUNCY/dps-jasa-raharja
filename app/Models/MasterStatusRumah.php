<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterStatusRumah extends Model
{
    use SoftDeletes;

    protected $table = 'master_status_rumah';
    protected $guarded = ['id'];
}
