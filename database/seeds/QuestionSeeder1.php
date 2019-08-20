<?php

use Illuminate\Database\Seeder;

class QuestionSeeder1 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language = \App\Models\Language::where('title', \App\Models\Language::ALL[0])->first();

        for ($i = 0; $i < 50; $i++) {
            $question = new \App\Models\Question();
            $question->title = "Question " . ($i+1);

            $question->language()->associate($language);

            $topic = \App\Models\Topic::where('title', \App\Models\Topic::ALL[rand(0, count(\App\Models\Topic::ALL)-1)])->first();

            $question->topic()->associate($topic);

            $question->save();

            $correct = rand(1,3);
            for ($j = 1; $j < 5; $j++) {
                $option = new \App\Models\Option();

                $option->question()->associate($question);
                $option->title = "Option " . $j;

                if ($j === $correct) {
                    $option->correct = true;
                }

                $option->save();
            }
        }
    }
}
