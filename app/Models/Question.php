<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }

    public function topic()
    {
        return $this->belongsTo('App\Models\Topic');
    }

    public function options()
    {
        return $this->hasMany('App\Models\Option');
    }
}
