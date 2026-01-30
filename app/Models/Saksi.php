<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Saksi extends Model
{
    use SoftDeletes;

    protected $table = 'saksi';
    protected $guarded = ['id'];
}
