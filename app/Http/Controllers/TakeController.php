<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Selection;
use App\Models\Test;
use App\Utils\StringUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TakeController extends Controller
{
    public function take(Request $request, $identifier)
    {
        $test = Test::where('identifier', $identifier)->with('selections')->first();

        return view('test', compact('test'));
    }

    public function assess(Request $request)
    {
        $data = $request->all();

        foreach ($data['answers'] as $key => $d) {
                $answer = Answer::where('selection_id', $d['selection_id'])->first();
                if ($answer === null) {
                    $answer = new Answer();
                }

                $answer->option_id = $d['option_id'];
                $answer->selection_id = $d['selection_id'];
                $answer->save();
        }

        $test = $answer->selection->test;
        $test->completed = true;
        $test->save();

        return response()->json(
            [
                'url' => route('start.results', [
                    'identifier' => $test->identifier
                ]),
            ]
        );
    }
}
