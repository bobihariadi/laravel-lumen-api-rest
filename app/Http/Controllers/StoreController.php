<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helper\GlobalHelper;
use Illuminate\Support\Str;


class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
       $this->$request = $request;
    }

    public function api(Request $request){
        $input  = $request->input();
        $action = $input["action"];
        $response = $this->$action($input, $request);
        return response()->json($response);
    }

    private function insert($input){
        return GlobalHelper::insert($input);
    }

    private function update($input){
        return GlobalHelper::update($input);
    }

    private function delete($input){
        return GlobalHelper::delete($input);
    }
}
