<?php

declare(strict_types=1);

/**
 * Laravel Version Manager Configuration
 *
 * This file contains the configuration settings for the Laravel Version Manager.
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Version File Path
    |--------------------------------------------------------------------------
    |
    | This value determines where the version file will be stored
    |
    */
    'file_path' => base_path('version.json'),

    /*
    |--------------------------------------------------------------------------
    | Version Format
    |--------------------------------------------------------------------------
    |
    | This value determines the format of the version number
    | Supported: "semantic", "sequential"
    |
    */
    'format' => 'semantic',
];
