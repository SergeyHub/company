<?php

namespace App\Console\Commands;

use App\Entity\ProfileSite\ProfileSite;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckSiteBanner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'banner:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $profileSites = ProfileSite::whereNull('next_check')->orWhere('next_check', '<', Carbon::now())->get();
        foreach ($profileSites as $site) {
            if (self::checkUrlOnSite($site->url,  url('/'))) {
                $site->status = 'active';
            } else {
                $site->status = 'not_active';
            }
            $site->next_check = Carbon::now()->addDays(7);
            $site->save();
        }
    }

    private function get_data($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Pretty Klicks Bot');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    private function fetch_url($url)
    {
        if (is_callable('curl_init')){
            $result = self::get_data($url);
            if (!empty($result)) {
                return $result;
            }
            return false;

        } else {
            ini_set('user_agent', 'Pretty Klicks Bot');
            $result = file_get_contents($url);

            if ($result !== false) {
                return $result;
            }
            return false;
        }
    }

    private function checkUrlOnSite($url, $test_url)
    {
        if (!$content = self::fetch_url($url)) {
            return false;
        }
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML($content);
        $urls = $dom->getElementsByTagName('a');
        $exists = false;

        for ($n = 0; $n < $urls->length; $n++) {
            $item = $urls->item($n);
            $href = $item->getAttribute('href');
            if (stristr($href, $test_url)) {
                $exists = true;
            }
        }
        libxml_use_internal_errors(false);

        if ($exists) {
            return true;
        }
        return false;
    }
}
