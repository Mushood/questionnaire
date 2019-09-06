<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Selection;
use App\Models\Test;
use App\Utils\StringUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StartController extends Controller
{
    public function index()
    {
        return view('start');
    }

    public function build(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|integer'
        ]);

        $key = StringUtils::generateRandomString(10);

        $test = new Test();
        $test->identifier = $key;
        if (Auth::user()) {
            $test->user_id = Auth::user()->id;
        }
        $test->save();

        $count = Question::count();

        $questionIds = [];
        for($i = 0; $i < $validatedData['number']; $i++) {
            $questionId = Question::skip(rand(1,$count - count($questionIds) - 1))->whereNotIn('id', $questionIds)->first()->id;
            array_push($questionIds, $questionId);
        }

        foreach($questionIds as $questionId) {
            $selection = new Selection();
            $selection->test()->associate($test);
            $selection->question_id = $questionId;
            $selection->save();
        }

        if (Auth::guest()) {
            $request->session()->put(Test::SESSION_KEY, $key);
        }

        return redirect()->route('start.take', ['identifier' => $key]);
    }
}
