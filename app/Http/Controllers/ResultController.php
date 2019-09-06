<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Selection;
use App\Models\Test;
use App\Utils\StringUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function results($identifier)
    {
        $test = Test::where('identifier', $identifier)->with('selections')->first();

        return view('test', compact('test'));
    }
}
