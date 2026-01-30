<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKecamatan extends Model
{
    use SoftDeletes;

    protected $table = 'master_kecamatan';
    protected $guarded = ['id'];

    public function kabupatenKota()
    {
        return $this->belongsTo(MasterKabupatenKota::class, 'kabkota_id');
    }

    public function kelurahan()
    {
        return $this->hasMany(MasterKelurahan::class, 'kecamatan_id');
    }
}
