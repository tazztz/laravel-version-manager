# Laravel Version Manager

A Laravel package for managing version control in your applications.

## Installation

You can install the package via composer:

```bash
composer require laravel-version-manager/tazz:dev-main
```

After installing, run the installation command:

```bash
php artisan version:install
```

This command will:
1. Create a `version.json` file in your storage directory with default version (1.0.0)
2. Create a `version.php` configuration file in your config directory
3. Create a ViewServiceProvider that injects the version into all views
4. Register the ViewServiceProvider in your `config/app.php`

### Manual Provider Registration

If the ViewServiceProvider is not automatically registered, you can register it manually in your `config/app.php` file:

```php
use Illuminate\Support\ServiceProvider;

'providers' => ServiceProvider::defaultProviders()->merge([
    /*
     * Package Service Providers...
         */
        LaravelVersionManager\Tazz\VersionManagerServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
    ])->toArray(),
...


Now You can use the version manager in your views by injected variable.

If you dont register the provider in config/app.php, then you can the facade directly.

## Usage

### In Blade Templates

You can display the version number in your blade templates in two ways:

```blade
<!-- Method 1: Using the injected variable (Requires ViewServiceProvider) -->
<p>Current Version: {{ $version ?? '1.0.0' }}</p>

<!-- Method 2: Using the Facade (Always available) -->
<p>Current Version: {{ \VersionManager::getVersion() }}</p>
```

### Via Command Line

```bash
# View current version
php artisan version:current

# Increment version numbers
php artisan version:increment patch   # Increases patch version (1.0.0 -> 1.0.1)
php artisan version:increment minor   # Increases minor version (1.0.1 -> 1.1.0)
php artisan version:increment major   # Increases major version (1.1.0 -> 2.0.0)
```

### In PHP Code

```php
use LaravelVersionManager\Tazz\Facades\VersionManager;

// Get current version
$version = VersionManager::getVersion();

// Increment version numbers
VersionManager::increment('patch');   // Increases patch version (1.0.0 -> 1.0.1)
VersionManager::increment('minor');   // Increases minor version (1.0.1 -> 1.1.0)
VersionManager::increment('major');   // Increases major version (1.1.0 -> 2.0.0)
```

### Version File Structure

The version information is stored in `storage/version.json` with the following structure:

```json
{
    "version": "1.0.0",
    "major": 1,
    "minor": 0,
    "patch": 0,
    "prerelease": "",
    "buildmetadata": "",
    "timestamp": "2024-03-14T12:00:00+00:00"
}
```

## Testing

Run the test suite:

```bash
composer test
```



## Security

If you discover any security related issues, please email tzatwork@gmail.com instead of using the issue tracker.

## Credits

- [Mohammad Tazz](https://github.com/tazztz)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information. 
