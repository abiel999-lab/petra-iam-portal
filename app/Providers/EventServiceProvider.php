<?php

namespace App\Providers;

use App\Listeners\SamlSignedInListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Slides\Saml2\Events\SignedIn;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SignedIn::class => [
            SamlSignedInListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
