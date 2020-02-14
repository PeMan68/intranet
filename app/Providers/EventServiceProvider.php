<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
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
		'App\Events\NewIssueComment' => [
			'App\Listeners\SendEmailToSubscribers',
		],
		'App\Events\NewIssue' => [
			'App\Listeners\SendEmailToResponsible',
			'App\Listeners\SendEmailToCustomer',
		],
		'App\Events\IssueOpenedFirstTime' => [
			'App\Listeners\SendEmailToCreator',
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
