<?php

namespace LaravelVersionManager\Tazz\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    protected $signature = 'version:install';
    protected $description = 'Install the version manager package';

    public function handle()
    {
        $this->info('Installing Version Manager...');

        // Create version file if it doesn't exist
        $this->createVersionFile();

        // Register provider in config/app.php
        $this->registerServiceProvider();

        $this->info('Version Manager installed successfully!');
    }

    protected function createVersionFile()
    {
        $versionFile = storage_path('version.json');

        if (!File::exists($versionFile)) {
            $defaultVersion = [
                'version' => '1.0.0',
                'major' => 0,
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

    protected function registerServiceProvider()
    {
        $configPath = config_path('app.php');
        $content = File::get($configPath);

        // Add ViewServiceProvider if not already registered
        if (!str_contains($content, 'App\Providers\ViewServiceProvider::class')) {
            $pattern = "/(RouteServiceProvider::class,\n\s*)/";
            $replacement = "$1        App\\Providers\\ViewServiceProvider::class,\n        ";

            $content = preg_replace($pattern, $replacement, $content);
            File::put($configPath, $content);

            $this->info('Registered ViewServiceProvider in config/app.php');
        }
    }
}
