<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       //
    }

    //
    public function show()    {
        return Str::random(32);
    }
}
