<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Selection extends Model
{
    protected $with = ['answers', 'question'];

    public function test()
    {
        return $this->belongsTo('App\Models\Test');
    }

    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }

    public function answers()
    {
        return $this->hasMany('App\Models\Answer');
    }
}
