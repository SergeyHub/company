<?php

namespace App\Console\Commands;

use App\Entity\Geo\Country\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use function PHPSTORM_META\type;
use VK\Client\Enums\VKLanguage;
use VK\Client\VKApiClient;

class LeaveOnlyEnglishInCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave_english:do';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /** @var array */
    protected $countries;

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
        $countries = Country::with('cities')->get();
        foreach ($countries as $country) {
            $result = preg_match('/^[a-zA-Z-]*$/', $country->slug, $matches);
            // если строка не состоит только из символов английского алфавита
            if (!$result) {
                $country->slug = Str::slug($country->slug, '-');
                $country->save();
            }
            foreach ($country->cities as $city) {
                $result = preg_match('/^[a-zA-Z-]*$/', $city->slug, $matches);
                // если строка не состоит только из символов английского алфавита
                if (!$result) {
                    $city->slug = Str::slug($city->slug, '-');
                    $city->save();
                }
            }
        }
    }
}
