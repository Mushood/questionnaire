<?php

namespace App\Http\Middleware;

use App\Models\Test;
use Closure;
use Illuminate\Support\Facades\Auth;

class QuestionnaireSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && $request->session()->has(Test::SESSION_KEY)) {
            $identifier = $request->session()->get(Test::SESSION_KEY);
            $test = Test::where('identifier', $identifier)->first();
            $test->user_id = Auth::user()->id;
            $test->save();

            $request->session()->forget(Test::SESSION_KEY);
        }

        return $next($request);
    }
}
