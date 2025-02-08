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
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        'version-manager' => VersionManager::class,
    ];

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        GetCurrentVersion::class,
        IncrementVersion::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/version.php',
            'version'
        );

        // Register commands
        $this->commands($this->commands);
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
        }
    }
}
