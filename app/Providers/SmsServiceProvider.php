<?php

namespace App\Providers;

use App\Sms\SmsInterface;
use App\Sms\LogSms;
use App\Sms\SampleSmsProvider;
use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $provider = match (env('SMS_DRIVER')) {
            'sample' => SampleSmsProvider::class,
            default  => LogSms::class
        };

        $this->app->bind(SmsInterface::class, $provider);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
