<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['url'];

    public $timestamps = false;

    public function reports() {
        return $this->hasMany('App\Models\Report');
    }
}
