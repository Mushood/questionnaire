@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">

            <div class="row">
                <div class="col-xs-4 image-level">
                    <img src="{{ asset('img/superman.svg') }}" class="img-responsive" alt="batman" />
                </div>
                <div class="col-xs-4">
                    <h1>How good are you?</h1>
                </div>
                <div class="col-xs-4 image-level">
                    <img src="{{ asset('img/flash.svg') }}" class="img-responsive" alt="batman" />
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <start
                        route_start="{{ route('start.index') }}"
                    ></start>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 image-level">
                    <img src="{{ asset('img/green_lantern.svg') }}" class="img-responsive" alt="batman" />
                </div>
                <div class="col-xs-4 start_desc">
                    <ul>
                        <li>HTML</li>
                        <li>CSS</li>
                        <li>PHP</li>
                    </ul>
                </div>
                <div class="col-xs-4 image-level">
                    <img src="{{ asset('img/captain.svg') }}" class="img-responsive" alt="batman" />
                </div>
            </div>
        </div>
    </div>
@endsection
