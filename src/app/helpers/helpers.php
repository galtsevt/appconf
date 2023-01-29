<?php
use Illuminate\Support\Facades\Cache;

function settings($key, $default = null)
{
    if (!$settings = Cache::get('admin_settings', null)) {
        $path = app_path('/settings/settings.json');
        if(is_file($path)) {
            $settings = json_decode(file_get_contents($path));
        }
        Cache::put('admin_settings', $settings);
    }
    if (isset($settings->$key)) {
        return $settings->$key;
    }
    return $default;
}
