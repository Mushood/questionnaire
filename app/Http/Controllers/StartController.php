<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class StartController extends Controller
{
    public function index()
    {
        return view('start');
    }

    public function build(Request $request)
    {
        $validatedData = $request->validate([
            'number' => 'required|integer'
        ]);

        $test = new Test();

        return view('test', compact('test'));
    }
}
