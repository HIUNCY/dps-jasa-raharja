<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class KasusKendaraan extends Pivot
{
    protected $table = 'kasus_kendaraan';
    protected $guarded = ['id'];
}
