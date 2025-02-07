<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz\Tests;

use Orchestra\Testbench\TestCase;
use LaravelVersionManager\Tazz\VersionManagerServiceProvider;

/**
 * Version Manager Test Class
 *
 * @package LaravelVersionManager\Tazz\Tests
 */
class VersionManagerTest extends TestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [VersionManagerServiceProvider::class];
    }

    /**
     * Test version increment functionality.
     *
     * @test
     * @return void
     */
    public function testVersionIncrement(): void
    {
        $this->artisan('version:increment')
            ->assertExitCode(0);

        $versionManager = app('version-manager');
        $this->assertEquals('0.0.1', $versionManager->getVersion());
    }
}
