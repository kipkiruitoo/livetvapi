<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


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

    return view('welcome')->with(['games' => collect($urls)]);
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


    // dd($decryption);

    return view('live')->with(['url' => $decryption]);
    }else{
        return redirect()->route('welcome');
    }

})->name('live');
