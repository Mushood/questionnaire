<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    const SESSION_KEY = "SESSION_QUESTIONNAIRE_KEY";

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function selections()
    {
        return $this->hasMany('App\Models\Selection');
    }
}
