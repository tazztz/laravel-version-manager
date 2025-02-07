# Laravel Version Manager

A Laravel package that helps you manage your project's version numbers using semantic versioning.

## Installation

You can install the package via composer:
## composer require laravel-version-manager/tazz
The package will automatically register its service provider and facade.

## Configuration

Publish the config file:
bash
php artisan vendor:publish --tag=version-config

This will create `config/version.php` with the following contents:

php
return [
// Where to store the version file
'file_path' => base_path('version.json'),
// Version format (semantic)
'format' => 'semantic',
];

## Usage

### Command Line Interface

The package provides several Artisan commands:
bash
Increment patch version (0.0.x)
php artisan version:increment
Increment minor version (0.x.0)
php artisan version:increment minor
Increment major version (x.0.0)
php artisan version:increment major


### Using in PHP Code

#### Facade Usage
php
use LaravelVersionManager\Tazz\Facades\VersionManager;
// Get current version
$currentVersion = VersionManager::getVersion();
// Returns: "1.2.3"
// Increment patch version
$newVersion = VersionManager::increment();
// Returns: "1.2.4"
// Increment minor version
$newVersion = VersionManager::increment('minor');
// Returns: "1.3.0"
// Increment major version
$newVersion = VersionManager::increment('major');
// Returns: "2.0.0"


#### Dependency Injection
php
use LaravelVersionManager\Tazz\VersionManager;
class YourController
{
protected $versionManager;
public function construct(VersionManager $versionManager)
{
$this->versionManager = $versionManager;
}
public function updateVersion()
{
$newVersion = $this->versionManager->increment('minor');
return response()->json(['version' => $newVersion]);
}
}

### Version File Structure

The package stores version information in a JSON file (default: `version.json`):
json
{
"major": 1,
"minor": 2,
"patch": 3
}

This represents version `1.2.3`.

## Common Use Cases

### 1. API Version Header
php
// In your middleware
class AddVersionHeader
{
public function handle($request, Closure $next)
{
$response = $next($request);
$version = app(VersionManager::class)->getVersion();
$response->header('X-App-Version', $version);
return $response;
}
}

### 2. Deployment Integration
php
// In your deployment service
class DeploymentService
{
public function deploy()
{
$oldVersion = VersionManager::getVersion();
// Perform deployment tasks
$this->runDeploymentTasks();
// Increment version after successful deployment
$newVersion = VersionManager::increment();
Log::info("Deployment completed: {$oldVersion} → {$newVersion}");
}
}

### 3. CI/CD Pipeline
yaml
GitHub Actions example
steps:
name: Increment Version
run: php artisan version:increment
name: Get Version
run: |
VERSION=$(php artisan version:get)
echo "VERSION=$VERSION" >> $GITHUB_ENV

## Best Practices

1. **Version Control**
   - Commit the `version.json` file to your repository
   - Automate version increments in your deployment pipeline

2. **Semantic Versioning**
   - Major (x.0.0): Breaking changes
   - Minor (0.x.0): New features (backwards compatible)
   - Patch (0.0.x): Bug fixes

3. **Deployment**
   - Increment versions during deployment
   - Maintain a changelog

## Troubleshooting

### Common Issues

1. **Version file not found**
   - Check file path in config
   - Verify file permissions
   - Run `php artisan version:increment` to create initial file

2. **Permission Issues**
   ```bash
   chmod 664 version.json
   chown www-data:www-data version.json
   ```

3. **Configuration Issues**
   ```bash
   php artisan config:clear
   php artisan config:cache
   ```

## Security

If you discover any security-related issues, please email tzatwork@gmail.com instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [Mohammad Tazz](https://github.com/yourgithub)

## Support

For questions and support, please use the issue tracker on GitHub.

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request
