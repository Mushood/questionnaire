<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Selection;
use App\Models\Test;
use Illuminate\Http\Request;

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

        $key = Test::generateRandomString(10);

        $test = new Test();
        $test->identifier = $key;
        $test->save();

        $count = Question::all()->count();

        for($i = 0; $i < $validatedData['number']; $i++) {
            $question = Question::find(rand(1,$count -1));

            $selection = new Selection();
            $selection->test()->associate($test);
            $selection->question()->associate($question);
            $selection->save();
        }


        return view('test', compact('test'));
    }

    public function assess(Request $request)
    {
        $data = $request->all();

        foreach ($data as $key => $d) {
            if (strpos($key,"uestion")) {
                $answer = new Answer();
                $answer->option_id = $d;
                $answer->selection_id = explode("_", $key)[1];
                $answer->save();
            }
        }

        $test = $answer->selection->test;

        return view('test', compact('test'));
    }
}
