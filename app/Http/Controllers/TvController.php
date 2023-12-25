<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TvController extends Controller
{
    //
    public function index()
    {
        return "404";



        // dd($canadalinks);

        // return view('tv')->with(["canadalinks" => $canadalinks]);
    }


    public function tvApi()
    {
        $canadatvs = Cache::remember('3645', 3600, function () {
            $canada = Http::withoutVerifying()->get('https://noodlestv.pages.dev/meta/channel/NOODLES%20TV8.json')->json();
            $espn = Http::withoutVerifying()->get('https://noodlestv.pages.dev/meta/channel/NOODLES%20TV4.json')->json();

            
            return [$canada, $espn];
        });


        // dd();

        $canadalinks = array_merge($canadatvs[0]['meta']['videos'], $canadatvs[1]['meta']['videos']);

        // dd(count($canadalinks));

        foreach ($canadalinks as $key => $link) {

            // dd('https://noodlestv.pages.dev/stream/channel/' . $link['id'] . '.json');
            $l = Cache::remember('nnklj-' . $link['id'], 3600, function () use ($link) {
                return Http::withoutVerifying()->get('https://noodlestv.pages.dev/stream/channel/' . $link['id'] . '.json')->json();
            });

            // dd($l);

            $canadalinks[$key]['streams'] = $l['streams'];
        }

        return response()->json($canadalinks);
    }
}
