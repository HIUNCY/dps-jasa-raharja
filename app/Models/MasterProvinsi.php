<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterProvinsi extends Model
{
    use SoftDeletes;

    protected $table = 'master_provinsi';
    protected $guarded = ['id'];

    public function kabupatenKota()
    {
        return $this->hasMany(MasterKabupatenKota::class, 'provinsi_id');
    }
}
