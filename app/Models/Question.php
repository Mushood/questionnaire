<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    const TYPES = [
        'standard'  => 1,
        'multiple'  => 2,
        'boolean'   => 3,
    ];
    protected $fillable = ['title'];

    protected $with = ['options'];

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
