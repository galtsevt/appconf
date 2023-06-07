<?php

use Illuminate\Support\Facades\Cache;

function settings($key, $group = null, $default = null)
{

    if (!$settings = Cache::get('admin_settings' . $group, null)) {
        $path = app_path('/settings/' . ($group ?? 'settings') . '.json');

        if (is_file($path)) {
            $settings = json_decode(file_get_contents($path));
        }
        Cache::put('admin_settings' . $group, $settings);
    }

    if (isset($settings->$key)) {
        return $settings->$key;
    }
    return $default;
}

function allSettingsForJS(): bool|string
{
    if (Cache::has('key')) {
        $settings = Cache::get('admin_settings_all');
    } else {
        foreach (new DirectoryIterator(app_path('settings')) as $fileInfo) {
            if ($fileInfo->isDot() or $fileInfo->isDir()) continue;
            $name = explode('.', $fileInfo->getFilename());
            $name = array_shift($name);
            $settings[$name] = json_decode(
                file_get_contents($fileInfo->getRealPath(), true),
                true
            );
        }
        Cache::put('admin_settings_all', $settings ?? []);
    }

    return json_encode($settings ?? []);
}
