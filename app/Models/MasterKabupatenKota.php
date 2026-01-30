<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKabupatenKota extends Model
{
    use SoftDeletes;

    protected $table = 'master_kabupaten_kota';
    protected $guarded = ['id'];

    public function provinsi()
    {
        return $this->belongsTo(MasterProvinsi::class, 'provinsi_id');
    }

    public function kecamatan()
    {
        return $this->hasMany(MasterKecamatan::class, 'kabkota_id');
    }
}
