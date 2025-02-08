<?php

namespace LaravelVersionManager\Tazz\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    protected $signature = 'version-manager:install';
    protected $description = 'Install the version manager package';

    public function handle()
    {
        $this->info('Installing Version Manager...');

        $this->installViewServiceProvider();
        $this->registerServiceProvider();

        $this->info('Version Manager installed successfully!');
        $this->info('You can now use {{ $version }} in any blade file or {{ \VersionManager::getVersion() }}');
    }

    protected function installViewServiceProvider()
    {
        $providerPath = app_path('Providers/ViewServiceProvider.php');

        if (File::exists($providerPath)) {
            if (!$this->confirm('ViewServiceProvider already exists. Do you want to override it?')) {
                return;
            }
        }

        $stub = File::get(__DIR__.'/../../stubs/ViewServiceProvider.stub');

        // Create Providers directory if it doesn't exist
        if (!File::exists(app_path('Providers'))) {
            File::makeDirectory(app_path('Providers'));
        }

        File::put($providerPath, $stub);
        $this->info('ViewServiceProvider created successfully.');
    }

    protected function registerServiceProvider()
    {
        $configPath = config_path('app.php');

        if (!File::exists($configPath)) {
            $this->error('Config file app.php not found!');
            return;
        }

        $contents = File::get($configPath);

        // Check if provider is already registered
        if (str_contains($contents, 'App\\Providers\\ViewServiceProvider::class')) {
            $this->info('ViewServiceProvider is already registered.');
            return;
        }

        // Find the providers array
        $pattern = "/('providers'\s*=>\s*\[\s*)([\s\S]*?)(^\s*\])/m";
        $replacement = "$1$2        App\\Providers\\ViewServiceProvider::class,\n$3";

        $contents = preg_replace($pattern, $replacement, $contents);

        File::put($configPath, $contents);
        $this->info('ViewServiceProvider registered in config/app.php');
    }
}
