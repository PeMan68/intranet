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
			'App\Listeners\Issues\NotifyFollowersOfNewComment',
		],
		'App\Events\NewIssue' => [
			'App\Listeners\Issues\AddFollowersToIssue',
            'App\Listeners\Issues\NotifyFollowersOfUpdatedIssue',
            'App\Listeners\Issues\NotifyCustomerOfNewIssue',
		],
		'App\Events\IssueOpenedFirstTime' => [
			'App\Listeners\Issues\NotifyIssueCreator',
		],
		'App\Events\IssueClosed' => [
			'App\Listeners\Issues\GenerateClosedComment',
            'App\Listeners\Issues\NotifyCustomerOfIssueClosed',
		],
		'App\Events\IssueReopened' => [
			'App\Listeners\Issues\GenerateReopenedComment',
			'App\Listeners\Issues\NotifyCustomerOfIssueReopened',
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
