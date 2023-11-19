<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/tv', function (Request $request){
    $response = Http::get('https://sportsonline.gl/prog.txt');
    // echo($response->body());

    $programms = $response->body();

    $linearray = preg_split('/\r\n|\r|\n/',$programms);

    $urlarrays = preg_grep("/^[0-9].*/", $linearray);

    $urls = array();

    foreach ($urlarrays as $url){
        $a = explode("| ", $url);

        $sm_array = explode("   ",$a[0]);

        $fa = [
            "time" => $sm_array[0],
            "title" => $sm_array[1],
            "url" => end($a)
        ];

        array_push($urls, $fa);
    }

    return response()->json($urls);
});
