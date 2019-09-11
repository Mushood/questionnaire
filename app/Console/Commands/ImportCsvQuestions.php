<?php

namespace App\Console\Commands;

use App\Models\CsvQuestion;
use App\Models\Language;
use App\Models\Question;
use App\Models\Option;
use App\Models\Topic;
use Illuminate\Console\Command;

class ImportCsvQuestions extends Command
{
    CONST CORRECT = 'Y';

    CONST IGNORE_OPTION = '-';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:questions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import questions in csv format';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $csvPath = storage_path('app/csv/');

        $files = scandir($csvPath);
        unset($files[1]); //.
        unset($files[0]); //..

        foreach ($files as $file) {
            if (CsvQuestion::where('name', $file)->exists()) {
                continue;
            }

            $row = 1;
            if (($handle = fopen($csvPath . $file, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);

                    $option = [];
                    $answer = [];

                    $quest    = $data[0];
                    $option[] = $data[1];
                    $option[] = $data[2];
                    $option[] = $data[3];
                    $option[] = $data[4];
                    $option[] = $data[5];
                    $answer[] = $data[6];
                    $answer[] = $data[7];
                    $answer[] = $data[8];
                    $answer[] = $data[9];
                    $answer[] = $data[10];
                    $language = $data[11];
                    $topic    = $data[12];
                    $link     = $data[13];

                    //number of correct answers
                    $cntYes   = count(array_filter($answer,function($a) {return $a===self::CORRECT;}));

                    if ($row === 1) {
                        //headers
                    }

                    if ($row !== 1) {
                        $question = new Question();
                        $question->title = $quest;

                        $language = Language::where('title', $language)->first();
                        $question->language()->associate($language);

                        $topic = Topic::where('title', $topic)->first();
                        $question->topic()->associate($topic);

                        $question->link = "https://www.example.com";

                        if ($cntYes > 1) {
                            $question->type = Question::TYPES['multiple'];
                        }

                        $question->save();

                        foreach ($option as $key => $opt) {
                            if ($opt == self::IGNORE_OPTION) {
                                continue;
                            }

                            $newOption = new Option();

                            $newOption->question()->associate($question);
                            $newOption->title = $opt;

                            if ($answer[$key] === self::CORRECT) {
                                $newOption->correct = true;
                            }

                            $newOption->save();
                        }
                    }

                    $row++;
                }
                fclose($handle);
            }
        }
    }
}
