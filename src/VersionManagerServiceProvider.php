<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz;

use Illuminate\Support\ServiceProvider;

class VersionManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/version.php',
            'version'
        );

        $this->app->singleton('version-manager', function ($app) {
            return new VersionManager($app);
        });
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/version.php' => config_path('version.php'),
            ], 'version-config');

            $this->commands([
                Commands\IncrementVersion::class,
                Commands\GetCurrentVersion::class,
            ]);
        }
    }
}
