<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Version Manager Facade
 *
 * @category Laravel
 * @package  LaravelVersionManager\Tazz
 * @author   Tazz <tzatwork@gmail.com>
 * @license  MIT https://opensource.org/licenses/MIT
 * @link     https://github.com/tazztz/laravel-version-manager
 *
 * @method static string getVersion()
 * @method static string increment(string $type)
 */
class VersionManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'version-manager';
    }
}
