<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ParseStreamUrls implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $response = Http::get('https://sportsonline.gl/prog.txt');
        // echo($response->body());

        $programms = $response->body();

        $linearray = preg_split('/\r\n|\r|\n/',$programms);

        $urlarrays = preg_grep("/^[0-9]*/", $linearray);

        $urls = array();

        foreach ($urlarrays as $url){
            $a = explode("|", $url);

            array_push($urls, $a);
        }

        echo json_encode($urls);
    }
}
