<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['highlighted', 'description', 'user_id', 'article_id', 'type_id'];

    public $timestamps = false;

    protected $hidden = ['user_id', 'article_id', 'type_id'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function article()
    {
        return $this->belongsTo('App\Models\Article');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\Type');
    }
}
