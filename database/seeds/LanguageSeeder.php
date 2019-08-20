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
        $languages = \App\Models\Language::ALL;

        foreach ($languages as $lang) {
            \App\Models\Language::create([
                'title' => $lang
            ]);
        }
    }
}
