# Laravel Version Manager

A Laravel package for managing version control in your applications.

## Installation

You can install the package via composer:

```bash
composer require laravel-version-manager/tazz
```

After installing, run the installation command:

```bash
php artisan version-manager:install
```

This will:
1. Create a ViewServiceProvider that injects the version into all views
2. Register the ViewServiceProvider in your `config/app.php`
3. Publish the configuration file

## Usage

### In Blade Templates

You can use the version number in your blade templates in two ways:

```blade
<!-- Using the injected variable -->
<p>Current Version: {{ $version }}</p>

<!-- Using the Facade -->
<p>Current Version: {{ \VersionManager::getVersion() }}</p>
```

### Via Command Line

```bash
# Get current version
php artisan version:current

# Increment patch version (0.0.1 -> 0.0.2)
php artisan version:increment patch

# Increment minor version (0.0.2 -> 0.1.0)
php artisan version:increment minor

# Increment major version (0.1.0 -> 1.0.0)
php artisan version:increment major
```

### In PHP Code

```php
use LaravelVersionManager\Tazz\Facades\VersionManager;

// Get current version
$version = VersionManager::getVersion();

// Increment version
VersionManager::increment('patch'); // For patch version (0.0.1 -> 0.0.2)
VersionManager::increment('minor'); // For minor version (0.0.2 -> 0.1.0)
VersionManager::increment('major'); // For major version (0.1.0 -> 1.0.0)
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information. 
