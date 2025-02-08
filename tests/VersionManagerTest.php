<?php

namespace LaravelVersionManager\Tazz\Tests;

use LaravelVersionManager\Tazz\VersionManager;
use Orchestra\Testbench\TestCase;

class VersionManagerTest extends TestCase
{
    protected $versionManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->versionManager = $this->app->make(VersionManager::class);
    }

    protected function getPackageProviders($app)
    {
        return ['LaravelVersionManager\Tazz\VersionManagerServiceProvider'];
    }

    public function test_can_increment_patch_version()
    {
        $initialVersion = $this->versionManager->getVersion();
        $newVersion = $this->versionManager->increment('patch');

        $this->assertNotEquals($initialVersion, $newVersion);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\.\d+$/', $newVersion);
    }

    public function test_can_increment_minor_version()
    {
        $initialVersion = $this->versionManager->getVersion();
        $newVersion = $this->versionManager->increment('minor');

        $this->assertNotEquals($initialVersion, $newVersion);
        $this->assertMatchesRegularExpression('/^\d+\.\d+\.0$/', $newVersion);
    }

    public function test_can_increment_major_version()
    {
        $initialVersion = $this->versionManager->getVersion();
        $newVersion = $this->versionManager->increment('major');

        $this->assertNotEquals($initialVersion, $newVersion);
        $this->assertMatchesRegularExpression('/^\d+\.0\.0$/', $newVersion);
    }
}
