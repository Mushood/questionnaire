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
