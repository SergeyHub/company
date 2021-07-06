<?php

namespace App\Listeners;

use App\Helpers\DigitalOcean;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\MediaLibrary\Events\MediaHasBeenAdded;

class MediaConversionCompletedListener implements ShouldQueue
{

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 10;

    /**
     * @param MediaHasBeenAdded $event
     */
    public function handle(MediaHasBeenAdded $event)
    {
        $media = $event->media;

        // обнуляем кэш файлов на CDN digitalocean
        (new DigitalOcean)->removeFileFromCdnCache($media->id . '/*');
    }

}
