<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterLoket extends Model
{
    use SoftDeletes;

    protected $table = 'master_loket';
    protected $guarded = ['id'];

    public function parent()
    {
        return $this->belongsTo(MasterLoket::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MasterLoket::class, 'parent_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'loket_id');
    }
}
