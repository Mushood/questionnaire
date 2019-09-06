<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Selection;
use App\Models\Test;
use App\Utils\StringUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResultController extends Controller
{
    use HandlesAuthorization;

    public function results($identifier)
    {
        $test = Test::where('identifier', $identifier)->with('selections')->first();

        $this->authorize('show', $test);

        return view('test', compact('test'));
    }
}
