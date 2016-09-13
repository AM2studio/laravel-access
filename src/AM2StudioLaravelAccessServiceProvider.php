<?php

namespace AM2Studio\LaravelAccess;

use Illuminate\Support\ServiceProvider;

class AM2StudioLaravelAccessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $laravel = app();
        $version = $laravel::VERSION;
        $version = trim(str_replace('(LTS)', '', $version));
        list($major, $minor, $patch) = explode('.', $version);

        if(3 <= $minor) {
            $this->loadMigrationsFrom(__DIR__.'/migrations');
        }

        $this->publishes([
            __DIR__.'/config/access.php' => config_path('access.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/migrations/' => database_path('migrations'),
        ], 'migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Access', function($app) {
            return new AM2StudioLaravelAccess;
        });
    }
}
