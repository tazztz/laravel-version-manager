<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz\Facades;

use Illuminate\Support\Facades\Facade;

class VersionManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'version-manager';
    }
} 