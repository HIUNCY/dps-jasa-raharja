<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKelurahan extends Model
{
    use SoftDeletes;

    protected $table = 'master_kelurahan';
    protected $guarded = ['id'];

    public function kecamatan()
    {
        return $this->belongsTo(MasterKecamatan::class, 'kecamatan_id');
    }
}
