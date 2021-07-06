<?php

namespace App\Providers;

use App\Events\SupportMessageCreated;
use App\Events\Users\UserDeleted;
use App\Listeners\SupportMessageListener;
use App\Listeners\UserDeletedListener;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\MediaLibrary\Events\MediaHasBeenAdded;
use App\Listeners\MediaConversionCompletedListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserDeleted::class => [
            UserDeletedListener::class,
        ],
        MediaHasBeenAdded::class => [
            MediaConversionCompletedListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
