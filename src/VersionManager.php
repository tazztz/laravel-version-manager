<<<<<<< HEAD
<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\File;

class VersionManager
{
    protected $app;
    protected $version;
    protected $filePath;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->filePath = config('version.file_path');
        $this->loadVersion();
    }

    protected function loadVersion(): void
    {
        if (File::exists($this->filePath)) {
            $this->version = json_decode(File::get($this->filePath), true);
        } else {
            $this->version = [
                'major' => 0,
                'minor' => 0,
                'patch' => 0,
            ];
            $this->saveVersion();
        }
    }

    public function increment(string $type = 'patch'): string
    {
        switch ($type) {
            case 'major':
                $this->version['major']++;
                $this->version['minor'] = 0;
                $this->version['patch'] = 0;
                break;
            case 'minor':
                $this->version['minor']++;
                $this->version['patch'] = 0;
                break;
            case 'patch':
                $this->version['patch']++;
                break;
        }

        $this->saveVersion();
        return $this->getVersion();
    }

    public function getVersion(): string
    {
        return sprintf(
            '%d.%d.%d',
            $this->version['major'],
            $this->version['minor'],
            $this->version['patch']
        );
    }

    protected function saveVersion(): void
    {
        File::put($this->filePath, json_encode($this->version, JSON_PRETTY_PRINT));
    }
=======
<?php

declare(strict_types=1);

namespace LaravelVersionManager\Tazz;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\File;

class VersionManager
{
    protected $app;
    protected $version;
    protected $filePath;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->filePath = config('version.file_path');
        $this->loadVersion();
    }

    protected function loadVersion(): void
    {
        if (File::exists($this->filePath)) {
            $this->version = json_decode(File::get($this->filePath), true);
        } else {
            $this->version = [
                'major' => 0,
                'minor' => 0,
                'patch' => 0,
            ];
            $this->saveVersion();
        }
    }

    public function increment(string $type = 'patch'): string
    {
        switch ($type) {
            case 'major':
                $this->version['major']++;
                $this->version['minor'] = 0;
                $this->version['patch'] = 0;
                break;
            case 'minor':
                $this->version['minor']++;
                $this->version['patch'] = 0;
                break;
            case 'patch':
                $this->version['patch']++;
                break;
        }

        $this->saveVersion();
        return $this->getVersion();
    }

    public function getVersion(): string
    {
        return sprintf(
            '%d.%d.%d',
            $this->version['major'],
            $this->version['minor'],
            $this->version['patch']
        );
    }

    protected function saveVersion(): void
    {
        File::put($this->filePath, json_encode($this->version, JSON_PRETTY_PRINT));
    }
>>>>>>> 33591ef2796f8dae8eb0768c480bb02cd84e1155
} 