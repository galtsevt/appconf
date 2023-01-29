<?php

namespace Galtsevt\AppConf\app\Services;

use DirectoryIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class ConfigService
{
    public function save(Request $request): void
    {
        $configs = $this->getConfigBuilder();
        $rules = [];
        foreach ($configs as $key => $config) {
            foreach ($config['data'] as $name => $item) {
                $rules[$name] = $item['rules'];
            }
        }
        $data = $request->validate($rules);
        $this->makeFile($data);
    }

    public function getConfigBuilder(): array
    {
        $files = [];
        foreach (new DirectoryIterator(app_path('settings/factory/')) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            $config = require $fileInfo->getPathname();
            if (isset($config['name'])) {
                $files[$fileInfo->getBasename('.' . $fileInfo->getExtension())] = $config;
            }
        }
        return $files;
    }

    private function makeFile($data): void
    {
        Cache::forget('admin_settings');
        file_put_contents(app_path('/settings/settings.json'), json_encode($data));
    }
}
