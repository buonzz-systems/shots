<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class UploadImage extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    private $image_path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image_path)
    {
        $this->image_path  = $image_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $info = pathinfo($this->filepath);
        $contents = Storage::disk('local')->get($this->filepath);
        Storage::disk('ftp')->put($info['basename'], $contents);
        Storage::disk('local')->delete($this->filepath);
    }
}
