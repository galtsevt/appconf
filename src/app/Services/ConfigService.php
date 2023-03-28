<?php

namespace Galtsevt\AppConf\app\Services;

use DirectoryIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfigService
{
    protected ?array $formElementContainers = null;

    public function save(Request $request): void
    {
        $rules = [];
        // extract validation rules from form elements object
        foreach ($this->getFormElementContainers() as $container) {
            if ($container->isVisible()) {
                $rules = array_merge($rules, $container->getAllValidationRules());
            }
        }
        $data = $request->validate($rules);
        // send data for modification before save it
        foreach ($this->getFormElementContainers() as $container) {
            if ($container->isVisible()) {
                $container->beforeSave($data);
            }
        }
        $data = array_merge($this->getOldSettings(), $data);
        $this->saveSettingsToFile($data);
    }

    public function getFormElementContainers(): array
    {
        if (!$this->formElementContainers) {
            $this->buildFormElementContainers();
        }
        return $this->formElementContainers;
    }

    public function buildFormElementContainers(): array
    {
        $files = [];
        foreach (new DirectoryIterator(app_path('settings/factory/')) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            $config = require $fileInfo->getPathname();
            $filename = $fileInfo->getBasename('.' . $fileInfo->getExtension());
            if (isset($config['name'])) {
                $this->formElementContainers[$filename] = new FormElementsContainer(
                    key: $filename,
                    name: $config['name'],
                    visible: $config['visible'] ?? null,
                    elements: $config['data']
                );
            }
        }
        return $this->formElementContainers;
    }

    private function getOldSettings(): array
    {
        $path = app_path('/settings/settings.json');
        if (is_file($path)) {
            $settings = json_decode(file_get_contents($path), true);
        }
        return $settings ?? [];
    }

    private function saveSettingsToFile($data): void
    {
        Cache::forget('admin_settings');
        file_put_contents(app_path('/settings/settings.json'), json_encode($data));
    }
}
