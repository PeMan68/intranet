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
		'App\Events\Issues\NewComment' => [
			'App\Listeners\Issues\NotifyFollowersOfNewComment',
		],
		'App\Events\Issues\NewIssue' => [
			'App\Listeners\Issues\AddFollowers',
            'App\Listeners\Issues\NotifyFollowersOfUpdatedIssue',
            'App\Listeners\Issues\NotifyCustomerOfNewIssue',
		],
		'App\Events\Issues\IssueOpenedFirstTime' => [
			'App\Listeners\Issues\NotifyCreator',
		],
		'App\Events\Issues\IssueClosed' => [
			'App\Listeners\Issues\GenerateClosedComment',
            'App\Listeners\Issues\NotifyCustomerOfClosedIssue',
		],
		'App\Events\Issues\IssueReopened' => [
			'App\Listeners\Issues\GenerateReopenedComment',
			'App\Listeners\Issues\NotifyCustomerOfReopenedIssue',
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
