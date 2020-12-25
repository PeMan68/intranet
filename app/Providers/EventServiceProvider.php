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
			'App\Listeners\IssueSendEmailToSubscribers',
		],
		'App\Events\NewIssue' => [
			'App\Listeners\IssueAddFollowers',
            'App\Listeners\IssueSendEmailToFollowers',
            'App\Listeners\IssueSendEmailToCustomer',
		],
		'App\Events\IssueOpenedFirstTime' => [
			'App\Listeners\IssueSendEmailToCreator',
		],
		'App\Events\IssueClosed' => [
			'App\Listeners\IssueGenerateClosedComment',
            'App\Listeners\IssueSendEmailToCustomerClosed',
		],
		'App\Events\IssueReopened' => [
			'App\Listeners\IssueGenerateReopenedComment',
			'App\Listeners\IssueSendEmailToCustomerReopened',
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
