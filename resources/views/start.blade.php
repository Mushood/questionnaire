@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Select number of questions</div>

                    <div class="panel-body">
                        @if ($errors->has('number'))
                            <span class="help-block">
                                <strong>{{ $errors->first('number') }}</strong>
                            </span>
                        @endif
                        <build
                            route_build="{{ route('start.build') }}"
                            csrf="{{ csrf_token() }}"
                            :languages="{{ $languages }}"
                        ></build>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
