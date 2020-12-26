<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The subscribers classes to register
     * 
     * When a listener is used to multiple evemts
     * 
     * @var array
     * 
     */

     protected $subscribe = [
         'App\Listeners\Issues\AddFollowers',

     ];
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
		'App\Events\Issues\UpdatedIssue' => [
			'App\Listeners\Issues\NotifyFollowersOfUpdate',
		],
		'App\Events\Issues\NewIssue' => [
            'App\Listeners\Issues\NotifyFollowersOfNewIssue',
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
