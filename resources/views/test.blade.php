@extends('layouts.app')

@section('content')
    <div class="container">
        <questionnaire
            route_assess="{{ route('start.assess') }}"
            :test_original="{{ $test }}"
            types_original="{{ json_encode(App\Models\Question::TYPES) }}"
        ></questionnaire>
    </div>
@endsection
