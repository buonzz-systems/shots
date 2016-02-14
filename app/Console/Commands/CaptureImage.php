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
        $client = new Client([
            'base_uri' => 'http://'. config('shots.cameras')[0]['hostname'] . ':' . config('shots.cameras')[0]['port'],
            'timeout'  => 2.0,
        ]);

        $uri = "/snapshot.cgi?user=" . config('shots.cameras')[0]['username'] . "&pwd=" . config('shots.cameras')[0]['password']  . "&" . rand(1,1000);

        $client->request('GET', $uri, ['sink' => storage_path('app/' . date("y-m-d-his") . ".jpg" ),
                                       'debug' => true]);
          
    }
}
