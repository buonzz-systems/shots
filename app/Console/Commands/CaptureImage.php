<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class CaptureImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shots:capture';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'capture an image from camera(s)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cameras = config('shots.cameras');

        foreach($cameras as $camera)
        {
            $this->save_image($camera);
        }
          
    }

    private function save_image($camera){

        $client = new Client([
            'base_uri' => 'http://'. $camera['hostname'] . ':' . $camera['port'],
            'timeout'  => 2.0
        ]);

        $uri = "/snapshot.cgi?user=" . $camera['username'] . "&pwd=" . $camera['password']  . "&" . rand(1,1000);
        Log::info($uri);
        $filepath = storage_path('app/' . date("y-m-d-his") . ".jpg");
        $resource = fopen($filepath, 'w');
        $client->request('GET', $uri, ['sink' => $resource]);
    }
}
