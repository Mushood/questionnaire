<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\Selection;
use App\Models\Test;
use App\Utils\StringUtils;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class QuestionnaireTest extends TestCase
{
    private $test;

    private $question;

    private $selection;

    public function setUp(): void
    {
        parent::setUp();

        $this->test = Test::create([
            'identifier' => StringUtils::generateRandomString(10)
        ]);

        $this->question = Question::first();

        $selection = new Selection();
        $selection->test()->associate($this->test);
        $selection->question_id = $this->question->id;
        $selection->save();

        $this->selection = $selection;

        Session::start();
    }

    public function testWelcome()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testStart()
    {
        $response = $this->get('/start');

        $response->assertStatus(200);
    }

    public function testTake()
    {
        $response = $this->get('/test/' . $this->test->identifier);

        $response->assertStatus(200);
    }

    public function testResults()
    {
        $response = $this->get('/test/results/' . $this->test->identifier);

        $response->assertStatus(200);
    }

    public function testBuild()
    {
        $response = $this->post('/build', [
            '_token' => csrf_token(),
            'number' => 5
        ]);

        $response->assertStatus(302);

        $response->assertSessionHasNoErrors();
    }

    public function testBuildNumberRequired()
    {
        $response = $this->post('/build', [
            '_token' => csrf_token()
        ]);

        $response->assertStatus(302);

        $keys = ['number'];

        $response->assertSessionHasErrors($keys);
    }

    public function testBuildNumberTooHigh()
    {
        $response = $this->post('/build', [
            '_token' => csrf_token(),
            'number' => 100
        ]);

        $response->assertStatus(302);

        $keys = ['number'];

        $response->assertSessionHasErrors($keys);
    }

    public function testAssess()
    {
        $response = $this->post('/assess', [
            '_token' => csrf_token(),
            'identifier' => $this->test->identifier,
            'answers' => [
                [
                    'type' => 1,
                    'answers' => [
                        [
                            'selection_id' => $this->selection->id,
                            'option_id' => $this->selection->question->options[0]->id
                        ]
                    ]
                ]
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $response->assertStatus(200);
    }
}
