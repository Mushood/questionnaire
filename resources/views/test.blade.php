@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($test->completed)
            <h2>Score: {{ $test->score() }} / {{ count($test->selections) }}</h2>
        @endif
        <questionnaire
            route_assess="{{ route('start.assess') }}"
            :test_original="{{ $test }}"
            types_original="{{ json_encode(App\Models\Question::TYPES) }}"
            csrf="{{ csrf_token() }}"
        ></questionnaire>
    </div>
@endsection
