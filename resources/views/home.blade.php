@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Dashboard
                    <span class="pull-right">
                        <a href="{{ route('start.index') }}">Take Test</a>
                    </span>
                </div>

                <div class="panel-body">
                    <ul>
                        @foreach($tests as $test)
                            <form id="delete-form-{{ $test->identifier }}" action="{{ route('start.delete', ['identifier' => $test->identifier]) }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="delete" />
                            </form>
                            @if($test->completed)
                                <li>
                                    <a href="{{ route('start.results', ['identifier' => $test->identifier]) }}">{{ $test->identifier }}</a>
                                    - ({{ $test->score()}} / {{ $test->selections->count() }})
                                    <a class="pull-right" href="{{ route('start.delete', ['identifier' => $test->identifier]) }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('delete-form-{{ $test->identifier }}').submit();">
                                        DELETE
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a href="{{ route('start.take', ['identifier' => $test->identifier]) }}">{{ $test->identifier }}</a>
                                    - Incomplete
                                    <a class="pull-right" href="{{ route('start.delete', ['identifier' => $test->identifier]) }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('delete-form-{{ $test->identifier }}').submit();">
                                        DELETE
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
