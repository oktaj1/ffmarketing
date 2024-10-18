<?php

namespace App\Providers;

use App\Models\Subscriber;
use App\Observers\SubscriberObserver;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Your existing event listeners...
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Subscriber::observe(SubscriberObserver::class);
    }
}