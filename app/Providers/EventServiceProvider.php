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
		'App\Events\Issues\UpdatedIssue' => [
            'App\Listeners\Issues\NotifyFollowersOfUpdate',
            'App\Listeners\Issues\NotifyCustomerOfUpdate',
		],
		'App\Events\Issues\NewIssue' => [
            'App\Listeners\Issues\NotifyFollowersOfNewIssue',
            'App\Listeners\Issues\NotifyCustomerOfNewIssue',
		],
		'App\Events\Issues\IssueCommentedFirstTime' => [
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
        'App\Events\Issues\IssuePaused' => [
            'App\Listeners\Issues\NotifyFollowersOfPaused',
        ],
        'App\Events\Issues\IssueWaitingForCustomer' => [
            'App\Listeners\Issues\NotifyFollowersOfExternal',
        ],
        'App\Events\Issues\IssueWaitingForInternal' => [
            'App\Listeners\Issues\NotifyFollowersOfInternal',
        ],
        'App\Events\Issues\IssueWaitingForComment' => [
            'App\Listeners\Issues\NotifyFollowersOfComment',
        ],
        'App\Events\Issues\CustomerNotContacted' => [
            'App\Listeners\Issues\NotifyFollowersOfNotContactedCustomer',
        ],
        'App\Events\Issues\IssuecommentOutboundMail' => [
            'App\Listeners\Issues\NotifyReceiverOfComment',
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
