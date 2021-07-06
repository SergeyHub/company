<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class DigitalOcean
{

    /** @var Client */
    private $client;

    /**
     * DigitalOcean constructor.
     */
    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'Authorization' => 'Bearer ' . config('digital_ocean.api_key'),
            ]
        ]);
    }

    /**
     * Remove file from cdn cache
     *
     * @param string $filename
     */
    public function removeFileFromCdnCache(string $filename)
    {
        $url = 'https://api.digitalocean.com/v2/cdn/endpoints/' . config('digital_ocean.cdn_id') . '/cache';

        $this->client->delete($url, [
            'json' => [
                'files' => [$filename],
            ],
        ]);
    }

}
