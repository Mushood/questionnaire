<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['title', 'language_id'];

    const ALL = [
        "basic", "functions", "strings", "arrays", "oop", "security", "data format and types", "input-output",
        "web features", "databases and sql", "error handling"
    ];

    public function language()
    {
        return $this->belongsTo('App\Models\Language');
    }
}
