<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['title'];

    public function question()
    {
        return $this->belongsTo('App\Models\Question');
    }
}
