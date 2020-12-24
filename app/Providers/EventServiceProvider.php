<?php

namespace App\Providers;

use App\Listeners\WebhookCallFailed;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Spatie\WebhookServer\Events\WebhookCallFailedEvent;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
        WebhookCallFailedEvent::class => [
            WebhookCallFailed::class
        ]
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
