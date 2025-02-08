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
     * Register any application services.
     */
    public function register(): void
    {
        // Register the main class
        $this->app->singleton('version-manager', function ($app) {
            return new VersionManager($app);
        });

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->app->singleton(InstallCommand::class);
            $this->app->singleton(GetCurrentVersion::class);
            $this->app->singleton(IncrementVersion::class);
        }

        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/version.php',
            'version'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            // Register the commands
            $this->app->make(InstallCommand::class);
            $this->app->make(GetCurrentVersion::class);
            $this->app->make(IncrementVersion::class);

            $this->commands([
                InstallCommand::class,
                GetCurrentVersion::class,
                IncrementVersion::class,
            ]);

            // Publish config
            $this->publishes([
                __DIR__ . '/../config/version.php' => config_path('version.php'),
                __DIR__ . '/../stubs/ViewServiceProvider.stub' => base_path('stubs/vendor/laravel-version-manager/ViewServiceProvider.stub'),
            ], 'version-config');
        }
    }
}
