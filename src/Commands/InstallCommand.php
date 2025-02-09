<?php

/**
 * Laravel Version Manager Install Command
 *
 * @category Commands
 * @package  LaravelVersionManager\Tazz\Commands
 * @author   Mohammad Tazz <tzatwork@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/tazztz/laravel-version-manager
 */

namespace LaravelVersionManager\Tazz\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * InstallCommand Class
 *
 * Handles the installation of the Version Manager package
 *
 * @category Commands
 * @package  LaravelVersionManager\Tazz\Commands
 * @author   Mohammad Tazz <tzatwork@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/tazztz/laravel-version-manager
 */
class InstallCommand extends Command
{
    protected $signature = 'version:install';
    protected $description = 'Install the version manager package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->info('Installing Version Manager...');

        // Create version file if it doesn't exist
        $this->createVersionFile();

        // Create config file
        $this->createConfigFile();

        // Create and register ViewServiceProvider
        $this->createViewServiceProvider();

        // Register provider in config/app.php
        $this->registerServiceProvider();

        $this->info('Version Manager installed successfully!');
    }

    /**
     * Create the version.json file in storage directory
     *
     * @return void
     */
    protected function createVersionFile()
    {
        $versionFile = storage_path('version.json');

        if (!File::exists($versionFile)) {
            $defaultVersion = [
                'version' => '1.0.0',
                'major' => 1,
                'minor' => 0,
                'patch' => 0,
                'prerelease' => '',
                'buildmetadata' => '',
                'timestamp' => now()->toIso8601String()
            ];

            File::put($versionFile, json_encode($defaultVersion, JSON_PRETTY_PRINT));
            $this->info('Created version file at: ' . $versionFile);
        }
    }

    /**
     * Create the version.php config file
     *
     * @return void
     */
    protected function createConfigFile()
    {
        $configPath = config_path('version.php');

        if (!File::exists($configPath)) {
            $stub = File::get(__DIR__ . '/../../config/version.php');
            File::put($configPath, $stub);
            $this->info('Created config file at: ' . $configPath);
        }
    }

    /**
     * Create the ViewServiceProvider class
     *
     * @return void
     */
    protected function createViewServiceProvider()
    {
        $providerPath = app_path('Providers/ViewServiceProvider.php');

        if (!File::exists($providerPath)) {
            // Create Providers directory if it doesn't exist
            if (!File::exists(app_path('Providers'))) {
                File::makeDirectory(app_path('Providers'), 0755, true);
            }

            $stub = File::get(__DIR__ . '/../../stubs/ViewServiceProvider.stub');
            File::put($providerPath, $stub);
            $this->info('Created ViewServiceProvider at: ' . $providerPath);
        }
    }

    /**
     * Register the ViewServiceProvider in config/app.php
     *
     * @return void
     */
    protected function registerServiceProvider()
    {
        $configPath = config_path('app.php');

        if (!File::exists($configPath)) {
            $this->error('Config file app.php not found!');
            return;
        }

        $content = File::get($configPath);

        // Check if ViewServiceProvider is already registered
        if (!str_contains($content, 'App\\Providers\\ViewServiceProvider::class')) {
            // Find the providers array
            $pattern = "/(RouteServiceProvider::class,\n\s*)/";
            $replacement = "$1        App\\Providers\\ViewServiceProvider::class,\n        ";

            $content = preg_replace($pattern, $replacement, $content);

            if ($content) {
                File::put($configPath, $content);
                $this->info('Registered ViewServiceProvider in config/app.php');
            } else {
                $this->error('Failed to register ViewServiceProvider in config/app.php');
            }
        }
    }
}
