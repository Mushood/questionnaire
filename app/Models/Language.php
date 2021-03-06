<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['title'];

    const ALL = [
        "php", "css", "html", "js"
    ];

    public function topics()
    {
        return $this->hasMany('App\Models\Topic');
    }
}
