<?php

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

        foreach ($topics as $topic) {
            \App\Models\Topic::create([
                'title' => $topic
            ]);
        }
    }
}
