<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    $fixtures = collect(File::json("fixtures.json"));

    // dd(collect($fixtures[0]));

    return view('welcome')->with(['fixtures' => collect($fixtures)]);
})->name('welcome');


Route::get('/news', function () {

    $fixtures = collect(File::json("fixtures.json"));

    // dd(collect($fixtures[0]));

    return view('news');
})->name('welcome');

Route::get("/live", function (Request $request) {

    if (isset($_GET['li']) ){
        
    $url = $_GET['li'];
    // Store the cipher method
    $ciphering = "AES-128-CTR";
    
    // Use OpenSSl Encryption method
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;

        // Non-NULL Initialization Vector for decryption
    $decryption_iv = '1234567891011121';
    
    // Store the decryption key
    $decryption_key = "GeeksforGeeks";
    
    // Use openssl_decrypt() function to decrypt the data
    $decryption=openssl_decrypt ($url, $ciphering, 
            $decryption_key, $options, $decryption_iv);

    $game = json_decode($decryption);

    if (isset($game->streams[0])) {
        return view('live')->with(['game' => $game ]);
    }

    return redirect()->route('welcome');
    // dd($decryption);

    
    }else{
        return redirect()->route('welcome');
    }

})->name('live');
