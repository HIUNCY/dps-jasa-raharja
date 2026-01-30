<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterJenisCidera extends Model
{
    use SoftDeletes;

    protected $table = 'master_jenis_cidera';
    protected $guarded = ['id'];
}
