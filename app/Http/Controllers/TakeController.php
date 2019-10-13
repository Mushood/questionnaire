<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Test;
use Illuminate\Http\Request;

class TakeController extends Controller
{
    public function take($identifier)
    {
        $test = Test::where('identifier', $identifier)->with('selections')->first();

        $selections = $test->selections;
        foreach ($selections as $selection) {
            $selection->question->code = str_replace(
                '\n', ' <br />', $selection->question->code
            );
        }

        $this->authorize('show', $test);

        return view('test', compact('test'));
    }

    public function assess(Request $request)
    {
        $data = $request->all();

        $test = Test::where('identifier', $data['identifier'])->with('selections')->first();

        $this->authorize('show', $test);

        foreach ($data['answers'] as $key => $d) {
            $multipleAnswers = $d['answers'];

            $answersPrev = Answer::where('selection_id', $multipleAnswers[0]['selection_id'])->get();

            if ($answersPrev != null) {
                foreach ($answersPrev as $answerPrev) {
                    $answerPrev->delete();
                }
            }

            foreach ($multipleAnswers as $multiple) {
                $answer = Answer::create($multiple);
            }
        }

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
