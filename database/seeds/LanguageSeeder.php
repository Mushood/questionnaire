<?php

use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $languages = [
            "php", "css", "html", "js"
        ];

        foreach ($languages as $lang) {
            \App\Models\Language::create([
                'title' => $lang
            ]);
        }
    }
}
