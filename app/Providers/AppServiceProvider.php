<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\Twilio;
use NotificationChannels\Twilio\TwilioConfig;
use Twilio\Rest\Client as TwilioClient;
use Illuminate\Contracts\Events\Dispatcher;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
{
    if (!config('services.twilio.enabled')) {
        return; // ← Twilio désactivé, on ne l’enregistre pas
    }

    app('Illuminate\Notifications\ChannelManager')->extend('twilio', function ($app) {
        $client = new TwilioClient(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $config = new TwilioConfig([
            'from' => config('services.twilio.from'),
        ]);

        $twilio = new Twilio($client, $config);
        $events = $app->make(Dispatcher::class);

        return new TwilioChannel($twilio, $events);
    });
   }
}