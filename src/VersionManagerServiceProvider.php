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
        $this->app->singleton(VersionManager::class);

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
            $this->commands([
                InstallCommand::class,
                GetCurrentVersion::class,
                IncrementVersion::class,
            ]);

            $this->publishes([
                __DIR__ . '/../config/version.php' => config_path('version.php'),
                __DIR__ . '/../stubs/ViewServiceProvider.stub' => base_path('stubs/vendor/laravel-version-manager/ViewServiceProvider.stub'),
            ], 'version-config');
        }
    }
}
