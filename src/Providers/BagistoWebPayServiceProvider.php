<?php

namespace Twgroup\WebPay\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

/**
 * BagistoWebPay service provider
 *
 * @author Guillermo Lobos <guillermo.lobos@twgroup.cl>
 * @copyright 2020 TWGroup (https://www.twgroup.cl)
 */
class BagistoWebPayServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap services.
    *
    * @return void
    */
    public function boot()
    {
        include __DIR__ . '/../Http/routes.php';
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'webpay');
        $this->loadMigrationsFrom(__DIR__ .'/../Database/Migrations');
    }

    /**
    * Register services.
    *
    * @return void
    */
    public function register()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php',
            'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php',
            'core'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/paymentmethods.php',
            'paymentmethods'
        );
    }
}
