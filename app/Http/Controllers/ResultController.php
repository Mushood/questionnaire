<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResultController extends Controller
{
    use HandlesAuthorization;

    public function results($identifier)
    {
        $test = Test::where('identifier', $identifier)->with('selections')->first();

        $selections = $test->selections;
        foreach ($selections as $selection) {
            $selection->question->code = str_replace(
                '\n', ' <br />', $selection->question->code
            );

            $selection->question->isCorrect = false;

            if (count($selection->answers) > 0) {
                $correctAnswers = $answered = [];
                foreach($selection->question->options as $option) {
                    if ($option->correct) {
                        $correctAnswers[] = $option->id;
                    }
                }
                foreach($selection->answers as $ans) {
                    $answered[] = $ans->option->id;
                }

                sort($correctAnswers);
                sort($answered);

                if (count($correctAnswers) === count($answered) && $correctAnswers === $answered) {
                    $selection->question->isCorrect = true;
                }
            }
        }

        $this->authorize('show', $test);

        return view('test', compact('test'));
    }

    public function delete($identifier)
    {
        $test = Test::where('identifier', $identifier)->with('selections')->first();

        $this->authorize('show', $test);

        $selections = $test->selections;

        foreach ($selections as $selection) {
            $answers = $selection->answers;

            foreach ($answers as $answer) {
                $answer->delete();
            }
            $selection->delete();
        }
        $test->delete();

        return redirect()->back();
    }
}
