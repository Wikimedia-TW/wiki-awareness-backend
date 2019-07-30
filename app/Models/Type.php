<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['type'];

    public $timestamps = false;

    public function reports() {
        return $this->hasMany('App\Models\Report');
    }
}
