<?php

/**
 * Laravel Version Manager
 *
 * PHP Version 8.2
 *
 * @category Library
 * @package  LaravelVersionManager\Tazz
 * @author   Tazz <tzatwork@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/tazztz/laravel-version-manager
 */

declare(strict_types=1);

namespace LaravelVersionManager\Tazz;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\File;

/**
 * Version Manager Class
 *
 * Handles version management for Laravel applications.
 *
 * @category Laravel
 * @package  LaravelVersionManager\Tazz
 * @author   Tazz <tzatwork@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/tazztz/laravel-version-manager
 */
class VersionManager
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The current version data.
     *
     * @var array<string, int>
     */
    protected $version;

    /**
     * The path to the version file.
     *
     * @var string
     */
    protected $filePath;

    /**
     * Create a new VersionManager instance.
     *
     * @param Application $app The application instance
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->filePath = config('version.file_path', storage_path('version.json'));
        $this->loadVersion();
    }

    /**
     * Load the version from file or create default.
     *
     * @return void
     */
    protected function loadVersion(): void
    {
        if (File::exists($this->filePath)) {
            $this->version = json_decode(File::get($this->filePath), true);
        } else {
            $this->version = [
                'major' => 0,
                'minor' => 0,
                'patch' => 0,
            ];
            $this->saveVersion();
        }
    }

    /**
     * Increment the version number.
     *
     * @param string $type The type of increment (major, minor, patch)
     *
     * @return string The new version number
     */
    public function increment(string $type = 'patch'): string
    {
        switch ($type) {
            case 'major':
                $this->version['major']++;
                $this->version['minor'] = 0;
                $this->version['patch'] = 0;
                break;
            case 'minor':
                $this->version['minor']++;
                $this->version['patch'] = 0;
                break;
            case 'patch':
                $this->version['patch']++;
                break;
        }

        $this->saveVersion();
        return $this->getVersion();
    }

    /**
     * Get the current version number.
     *
     * @return string The current version number
     */
    public function getVersion(): string
    {
        return sprintf(
            '%d.%d.%d',
            $this->version['major'],
            $this->version['minor'],
            $this->version['patch']
        );
    }

    /**
     * Save the version to file.
     *
     * @return void
     */
    protected function saveVersion(): void
    {
        File::put($this->filePath, json_encode($this->version, JSON_PRETTY_PRINT));
    }
}
