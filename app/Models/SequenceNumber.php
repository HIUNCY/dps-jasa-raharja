<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SequenceNumber extends Model
{
    protected $table = 'sequence_numbers';
    protected $guarded = ['id'];
}
