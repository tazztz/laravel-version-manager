<?php

declare(strict_types=1);

/**
 * Laravel Version Manager Service Provider
 *
 * @category Library
 * @package  LaravelVersionManager\Tazz
 * @author   Mohammad Tazz <tzatwork@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/tazztz/laravel-version-manager
 */

namespace LaravelVersionManager\Tazz;

use Illuminate\Support\ServiceProvider;
use LaravelVersionManager\Tazz\Commands\InstallCommand;
use LaravelVersionManager\Tazz\Commands\GetCurrentVersion;
use LaravelVersionManager\Tazz\Commands\IncrementVersion;

/**
 * Version Manager Service Provider
 *
 * Handles the registration of services and commands for the version manager.
 *
 * @category Library
 * @package  LaravelVersionManager\Tazz
 * @author   Mohammad Tazz <tzatwork@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/tazztz/laravel-version-manager
 */
class VersionManagerServiceProvider extends ServiceProvider
{
    /**
     * All commands to be registered.
     *
     * @var array<class-string>
     */
    protected array $commands = [
        InstallCommand::class,
        GetCurrentVersion::class,
        IncrementVersion::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the main class
        $this->app->singleton(
            'version-manager',
            function ($app) {
                return new VersionManager($app);
            }
        );

        // Register commands
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        // Merge config
        $this->mergeConfigFrom(
            __DIR__ . '/../config/version.php',
            'version'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            // Publish config
            $this->publishes(
                [
                    __DIR__ . '/../config/version.php' => config_path('version.php'),
                    __DIR__ . '/../stubs/ViewServiceProvider.stub' => base_path(
                        'stubs/vendor/laravel-version-manager/ViewServiceProvider.stub'
                    ),
                ],
                'version-config'
            );
        }
    }
}
