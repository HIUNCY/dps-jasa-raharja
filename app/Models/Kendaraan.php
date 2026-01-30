<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kendaraan extends Model
{
    use SoftDeletes;

    protected $table = 'kendaraan';
    protected $guarded = ['id'];

    public function jenisKendaraan()
    {
        return $this->belongsTo(MasterJenisKendaraan::class, 'jenis_kendaraan_id');
    }

    public function kasus()
    {
        return $this->belongsToMany(KasusKecelakaan::class, 'kasus_kendaraan')
                    ->withPivot('peran', 'keterangan')
                    ->withTimestamps();
    }
}
