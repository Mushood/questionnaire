<?php

namespace App\Http\Controllers;

use App\Models\Answer;
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

    /**
     * #TODO set unique constraints for selections
     */
    public function build(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|integer'
        ]);

        $key = StringUtils::generateRandomString(10);

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

        if (Auth::guest()) {
            $request->session()->put(Test::SESSION_KEY, $key);
        }

        return redirect()->route('start.take', ['identifier' => $key]);
    }

    public function take(Request $request, $identifier)
    {
        $test = Test::where('identifier', $identifier)->first();

        return view('test', compact('test'));
    }

    /**
     * #TODO provide score
     * #TODO allow update of answers
     * #TODO eager load sql queries
     * #TODO check with horizon
     * #TODO validate data
     */
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

        return redirect()->route('start.results', [
            'identifier' => $answer->selection->test->identifier
        ]);
    }

    public function results($identifier)
    {
        $test = Test::where('identifier', $identifier)->first();

        return view('test', compact('test'));
    }
}
