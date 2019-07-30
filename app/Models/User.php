<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['fingerprint'];

    public $timestamps = false;

    public function reports() {
        return $this->hasMany('App\Models\Report');
    }
}
