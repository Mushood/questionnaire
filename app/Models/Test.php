<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    const SESSION_KEY = "SESSION_QUESTIONNAIRE_KEY";

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function selections()
    {
        return $this->hasMany('App\Models\Selection');
    }

    public function score()
    {
         $score = 0;

         foreach ($this->selections as $selection) {
             if ($selection->question->type == Question::TYPES['standard']) {
                 if ($selection->answers[0]->option->correct) {
                     $score++;
                 }
             }
             if ($selection->question->type == Question::TYPES['multiple']) {
                 $correctAns = [];
                 $numCorrect = 0;
                 foreach ($selection->question->options as $opt) {
                     if ($opt->correct) {
                         $numCorrect++;
                     }
                 }

                 foreach ($selection->answers as $answer) {
                     if ($answer->option->correct) {
                         array_push($correctAns, $answer);
                     }
                 }

                 if (count($correctAns) == $numCorrect && count($selection->answers) == $numCorrect) {
                     $score++;
                 }
             }
         }

         return $score;
    }
}
