<?php

namespace NotificationChannels\SmsRu;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Zelenin\SmsRu\Auth\ApiIdAuth;
use Zelenin\SmsRu\Api;

class SmsRuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->singleton(Api::class, function () {
            $apiId = Config::get('services.smsru.api_id', null);
            return new Api(new ApiIdAuth($apiId));
        });
        $this->app->singleton(SmsRuChannel::class, function ($app) {
            $sender = Config::get('services.smsru.sender', null);
            return new SmsRuChannel($app->make(Api::class), $sender);
        });
    }
}
