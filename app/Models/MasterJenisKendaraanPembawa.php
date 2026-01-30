<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterJenisKendaraanPembawa extends Model
{
    use SoftDeletes;

    protected $table = 'master_jenis_kendaraan_pembawa';
    protected $guarded = ['id'];
}
