<?php

use App\Models\Language;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topics = \App\Models\Topic::ALL;

        $language = Language::where('title', Language::ALL[0])->first();

        foreach ($topics as $topic) {
            \App\Models\Topic::create([
                'title'         => $topic,
                'language_id'   => $language->id
            ]);
        }
    }
}
