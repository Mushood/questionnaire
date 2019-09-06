<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['option_id', 'selection_id'];

    protected $with = ['option'];

    public function selection()
    {
        return $this->belongsTo('App\Models\Selection');
    }

    public function option()
    {
        return $this->belongsTo('App\Models\Option');
    }
}
