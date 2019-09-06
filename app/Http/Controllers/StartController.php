<?php

namespace App\Http\Controllers;

use App\Models\Language;
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
        $languages = Language::with('topics')->get();

        return view('start', compact('languages'));
    }

    public function build(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|integer|min:1',
            'language_id' => 'nullable|integer',
            'topic_id' => 'nullable|integer',
        ]);

        $query = Question::where('id', '>', 0);
        $query = $this->applyFilters($validatedData, $query);
        $count = $query->count();

        $request->validate([
            'number' => "required|integer|max:{$count}",
        ]);

        $key = StringUtils::generateRandomString(10);

        $test = new Test();
        $test->identifier = $key;
        if (Auth::user()) {
            $test->user_id = Auth::user()->id;
        }
        $test->save();

        $questionIds = [];
        for($i = 0; $i < $validatedData['number']; $i++) {
            $query = Question::skip(rand(1,$count - count($questionIds) - 1));
            $query = $this->applyFilters($validatedData, $query);
            $questionId = $query->whereNotIn('id', $questionIds)->first()->id;
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

    private function applyFilters(array $data, $query)
    {
        if (!empty($data['language_id'])) {
            $query = $query->where('language_id', $data['language_id']);
        }

        if (!empty($data['topic_id'])) {
            $query = $query->where('topic_id', $data['topic_id']);
        }

        return $query;
    }
}
