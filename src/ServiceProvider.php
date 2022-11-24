<?php

namespace InertiaDashboardKit;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/inertia-dashboard.php' => config_path('inertia-dashboard.php'),
            ], 'config');

            $this->commands([
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/inertia-dashboard.php', 'inertia-dashboard');
    }
}
