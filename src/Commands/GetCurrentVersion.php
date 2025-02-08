<?php

namespace LaravelVersionManager\Tazz\Commands;

use Illuminate\Console\Command;
use LaravelVersionManager\Tazz\Facades\VersionManager;

class GetCurrentVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'version:current';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the current version of the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $version = VersionManager::getVersion();
        $this->info("Current version: {$version}");
    }
}
