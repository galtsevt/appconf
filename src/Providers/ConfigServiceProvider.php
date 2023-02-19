<?php
namespace Galtsevt\AppConf\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->mergeConfigFrom(
            __DIR__.'/../config/admin_settings.php', 'admin_settings'
        );

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminConfig');

        $this->publishes([
            __DIR__.'/../config/admin_settings.php' => config_path('admin_settings.php'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/adminConfig'),
            __DIR__.'/../app/settings' => app_path('settings'),
        ]);
    }
}
