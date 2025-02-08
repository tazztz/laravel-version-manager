<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz;

use Illuminate\Support\ServiceProvider;
use LaravelVersionManager\Tazz\Commands\InstallCommand;
use LaravelVersionManager\Tazz\Commands\GetCurrentVersion;
use LaravelVersionManager\Tazz\Commands\IncrementVersion;

class VersionManagerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
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

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/version.php' => config_path('version.php'),
                __DIR__ . '/../stubs/ViewServiceProvider.stub' => base_path('stubs/vendor/laravel-version-manager/ViewServiceProvider.stub'),
            ], 'version-config');

            $this->commands([
                InstallCommand::class,
                GetCurrentVersion::class,
                IncrementVersion::class,
            ]);
        }
    }
}
