<?php

namespace Invibe\KvetyPreVas;

use Illuminate\Support\ServiceProvider;

/**
 * Class KvetyPreVasServiceProvider
 * @author Adam Ondrejkovic
 * @package Invibe\CommonHelpers
 */
class KvetyPreVasServiceProvider extends ServiceProvider
{
    /**
     * @author Adam Ondrejkovic
     */
    public function register()
    {
        $this->app->bind('kvetyprevas', function ($app) {
            return new KvetyPreVas();
        });

        $this->mergeConfigFrom(__DIR__.'/config/config.php', 'kvetyprevas');
    }

    /**
     * @author Adam Ondrejkovic
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->publishes([
                __DIR__.'/config/config.php' => config_path('kvetyprevas.php'),
            ], 'config');

        }
    }
}
