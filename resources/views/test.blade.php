@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('start.assess') }}">
            {{ csrf_field() }}
            <h1>{{ $test->identifier }} - @if($test->completed) {{ $test->score() }} @endif</h1>
            @foreach($test->selections as $selection)
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{ $selection->question->title }}</div>

                            <div class="panel-body">
                                @foreach($selection->question->options as $option)
                                    <input type="radio" name="question_{{ $selection->id }}" value="{{ $option->id }}"> {{ $option->title }}<br>
                                @endforeach
                            </div>

                            @if($selection->answer != null)
                                <div class="panel-footer">
                                    {{ $selection->answer->option->title }} -
                                    @if($selection->answer->option->correct)
                                        Correct
                                    @else
                                        Wrong
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>

        </form>
    </div>
@endsection
