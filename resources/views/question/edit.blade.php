@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('question.update', ['question' => $question->id]) }}" method="POST">
            {{ csrf_field() }}
            <div class="row question-group">
                <div class="form-group">
                    <label for="active" class="col-md-2 control-label">Active</label>
                    <div class="col-md-10">
                        <input type="checkbox" value="1" name="questiona_{{ $question->id }}" @if($question->active) checked="checked" @endif  />
                    </div>
                </div>
            </div>
            <div class="row question-group">
                <div class="form-group">
                    <label for="title" class="col-md-2 control-label">Title</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="title" value="{{ $question->title }}" />
                    </div>
                </div>
            </div>
            <div class="row question-group">
                <div class="form-group">
                    <label for="code" class="col-md-2 control-label">Code</label>
                    <div class="col-md-10">
                        <textarea rows="3" class="form-control" name="code">{{ $question->code }}</textarea>
                    </div>
                 </div>
            </div>
            <div class="row question-group">
                <div class="form-group">
                    <label for="explanation" class="col-md-2 control-label">Explanation</label>
                    <div class="col-md-10">
                        <input class="form-control" type="text" name="explanation" value="{{ $question->explanation }}" />
                    </div>
                </div>
            </div>
            <div class="row question-group">
                <div class="form-group">
                    <label for="number" class="col-md-2 control-label">Languages</label>

                    <div class="col-md-10">
                        <select name="language" class="form-control" name="language">
                            <option value="">All Languages</option>
                            @foreach($languages as $lang)
                                <option value="{{ $lang->id }}" @if($lang->id == $question->language_id) selected="selected" @endif>{{ $lang->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row question-group">
                <div class="form-group">
                    <label for="number" class="col-md-2 control-label">Topics</label>

                    <div class="col-md-10">
                        <select name="topic" class="form-control" name="language">
                            <option value="">All Topics</option>
                            @foreach($languages as $lang)
                                @foreach($lang->topics as $topic)
                                    <option value="{{ $topic->id }}" @if($topic->id == $question->topic_id) selected="selected" @endif>{{ $topic->title }}</option>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row question-group">
                <div class="form-group">
                    <label for="link" class="col-md-2 control-label">Link</label>

                    <div class="col-md-10">
                        <input class="form-control" type="text" name="link" value="{{ $question->link }}" />
                    </div>
                </div>
            </div>

            <h3>Options</h3>

            @foreach($question->options as $option)
            <div class="row question-group">
                <div class="form-group">
                    <label for="option_{{ $option->id }}" class="col-md-2 control-label">Title</label>
                    <div class="col-md-8">
                        <input class="form-control" type="text" name="option_{{ $option->id }}" value="{{ $option->title }}" />
                    </div>
                    <div class="col-md-2">
                        <input type="checkbox" value="1" name="options_{{ $option->id }}" @if($option->correct) checked="checked" @endif /> Correct
                    </div>
                </div>
            </div>
            @endforeach

            @for($i = 1; $i < (6 - count($question->options)); $i++)
                <div class="row question-group">
                    <div class="form-group">
                        <label for="link" class="col-md-2 control-label">Title New</label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" name="option_{{ count($question->options) + $i }}" value="" />
                        </div>
                        <div class="col-md-2">
                            <input type="checkbox" value="1" name="options_{{ count($question->options) + $i }}" /> Correct
                        </div>
                    </div>
                </div>
            @endfor


            <button class="btn btn-primary" type="submit">Submit</button>
        </form>
    </div>
@endsection
