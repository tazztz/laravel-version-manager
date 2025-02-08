<?php
/**
 * ViewServiceProvider Class
 * 
 * This provider shares the version number with all views in the application.
 * 
 * @package App\Providers
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use LaravelVersionManager\Tazz\Facades\VersionManager;

/**
 * ViewServiceProvider handles sharing version information with views
 */
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     * 
     * Shares the version number with all views.
     *
     * @return void
     */
    public function boot(): void
    {
        try {
            // Share version with all views using the Facade
            View::share('version', VersionManager::getVersion());
        } catch (\Exception $e) {
            // If version file doesn't exist yet, set default version
            View::share('version', '0.0.0');
        }
    }
}
