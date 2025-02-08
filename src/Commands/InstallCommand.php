<?php

namespace LaravelVersionManager\Tazz\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Class InstallCommand
 *
 * @package LaravelVersionManager\Tazz\Commands
 */
class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'version:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the version manager package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Installing Version Manager...');

        $this->createVersionFile();
        $this->installViewServiceProvider();
        $this->registerServiceProvider();
        $this->publishConfig();

        $this->info('Version Manager installed successfully!');
        $this->info('You can now use {{ $version }} in any blade file or {{ \VersionManager::getVersion() }}');
    }

    /**
     * Create the version file.
     *
     * @return void
     */
    protected function createVersionFile(): void
    {
        $versionFile = storage_path('version.json');

        if (!File::exists($versionFile)) {
            $defaultVersion = [
                'major' => 0,
                'minor' => 0,
                'patch' => 0,
            ];

            // Create storage directory if it doesn't exist
            if (!File::exists(storage_path())) {
                File::makeDirectory(storage_path());
            }

            File::put($versionFile, json_encode($defaultVersion, JSON_PRETTY_PRINT));
            $this->info('Version file created at: ' . $versionFile);
        } else {
            $this->info('Version file already exists.');
        }
    }

    /**
     * Install the ViewServiceProvider.
     *
     * @return void
     */
    protected function installViewServiceProvider(): void
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

    /**
     * Register the service provider in config/app.php.
     *
     * @return void
     */
    protected function registerServiceProvider(): void
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

        // Find the providers array closing bracket
        $pattern = "/(App\\\\Providers\\\\RouteServiceProvider::class,\n\s*)(])(\s*)/s";
        $replacement = "$1        App\\Providers\\ViewServiceProvider::class,\n    $2$3";

        $contents = preg_replace($pattern, $replacement, $contents);

        if ($contents === null) {
            $this->error('Failed to update config/app.php. Please add ViewServiceProvider manually.');
            return;
        }

        File::put($configPath, $contents);
        $this->info('ViewServiceProvider registered in config/app.php');
    }

    /**
     * Publish the package configuration.
     *
     * @return void
     */
    protected function publishConfig(): void
    {
        $this->call('vendor:publish', [
            '--provider' => 'LaravelVersionManager\\Tazz\\VersionManagerServiceProvider',
            '--tag' => 'version-config'
        ]);
    }
}
