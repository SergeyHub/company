<?php

namespace App\Providers;

use App\Services\Sms\SmsSender;
use App\Services\Sms\SmsTwilio;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SmsSender::class, function (Application $app) {
            $config = $app->make('config')->get('sms');

            switch ($config['driver']) {
                case 'twilio':
                    $params = $config['drivers']['twilio'];
                    if (!empty($params['account_id']) && !empty($params['token']) && !empty($params['number'])) {
                        return new SmsTwilio($params['account_id'], $params['token'], $params['number']);
                    }
                    throw new \InvalidArgumentException("Incorrect SMS driver parameters");
                default:
                    throw new \InvalidArgumentException('Undefined SMS driver ' . $config['driver']);
            }
        });
    }
}
