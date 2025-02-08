# Laravel Version Manager

A Laravel package for managing version control in your applications.

## Installation

You can install the package via composer:

```bash
composer require laravel-version-manager/tazz
```

## Usage

```php
// Increment patch version (0.0.1 -> 0.0.2)
VersionManager::increment('patch');

// Increment minor version (0.0.2 -> 0.1.0)
VersionManager::increment('minor');

// Increment major version (0.1.0 -> 1.0.0)
VersionManager::increment('major');

// Get current version
$version = VersionManager::getVersion();
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="LaravelVersionManager\Tazz\VersionManagerServiceProvider"
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information. 