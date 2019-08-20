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
        $topics = [
            "basic", "functions", "strings", "arrays", "oop", "security", "data format and types", "input-output",
            "web features", "databases and sql", "error handling"
        ];

        foreach ($topics as $topic) {
            \App\Models\Topic::create([
                'title' => $topic
            ]);
        }
    }
}
