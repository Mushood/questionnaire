<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function edit(Question $question)
    {
        $question->load('options');

        $languages = Language::with('topics')->get();

        return view('question.edit', compact('question' ,'languages'));
    }

    public function update(Request $request, Question $question)
    {
        $data = $request->all();

        $question->active = false;
        if (isset($data['questiona_' . $question->id])) {
            $question->active = true;
        }

        $question->title        = $data['title'];
        $question->code         = $data['code'];
        $question->explanation  = $data['explanation'];
        $question->language_id  = $data['language'];
        $question->topic_id     = $data['topic'];
        $question->link         = $data['link'];
        $question->save();

        $options    = $question->options;
        $count      = 5 - count($question->options);

        foreach ($options as $option) {
            $option->title      = $data['option_' . $option->id];
            $option->correct    = false;
            if (isset($data['options_' . $option->id])) {
                $option->correct = true;
            }
            $option->save();
        }

        for($i = 1 ; $i <= $count; $i++) {
            $option                 = new Option();
            $option->title          = $data['option_' . (count($question->options) + $i)];
            $option->question_id    = $question->id;
            $option->correct        = false;
            if (isset($data['options_' . (count($question->options) + $i)])) {
                $option->correct = true;
            }
            $option->save();
        }

        return redirect()->back();
    }
}
