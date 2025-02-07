<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz\Commands;

use Illuminate\Console\Command;

class IncrementVersion extends Command
{
    protected $signature = 'version:increment {type=patch : The type of increment (major, minor, patch)}';
    protected $description = 'Increment the project version number';

    public function handle(): void
    {
        $type = $this->argument('type');
        $versionManager = app('version-manager');
        
        $oldVersion = $versionManager->getVersion();
        $newVersion = $versionManager->increment($type);

        $this->info("Version incremented from {$oldVersion} to {$newVersion}");
    }
=======
<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz\Commands;

use Illuminate\Console\Command;

class IncrementVersion extends Command
{
    protected $signature = 'version:increment {type=patch : The type of increment (major, minor, patch)}';
    protected $description = 'Increment the project version number';

    public function handle(): void
    {
        $type = $this->argument('type');
        $versionManager = app('version-manager');
        
        $oldVersion = $versionManager->getVersion();
        $newVersion = $versionManager->increment($type);

        $this->info("Version incremented from {$oldVersion} to {$newVersion}");
    }
>>>>>>> 33591ef2796f8dae8eb0768c480bb02cd84e1155
} 