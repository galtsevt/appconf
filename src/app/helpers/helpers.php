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
