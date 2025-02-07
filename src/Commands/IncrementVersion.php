<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz\Commands;

use Illuminate\Console\Command;

/**
 * Command to increment the project version number.
 *
 * @category Laravel
 * @package  LaravelVersionManager\Tazz
 * @author   Tazz <tzatwork@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/tazztz/laravel-version-manager
 */
class IncrementVersion extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'version:increment {type=patch : The type of increment (major, minor, patch)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increment the project version number';

    /**
     * Handle the command execution.
     *
     * @return void
     */
    public function handle(): void
    {
        $type = $this->argument('type');
        $versionManager = app('version-manager');

        $oldVersion = $versionManager->getVersion();
        $newVersion = $versionManager->increment($type);

        $this->info("Version incremented from {$oldVersion} to {$newVersion}");
    }
}
