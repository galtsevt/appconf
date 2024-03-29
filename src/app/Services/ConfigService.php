<?php

namespace Galtsevt\AppConf\app\Services;

use DirectoryIterator;
use Galtsevt\LaravelSeo\App\Facades\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ConfigService
{
    protected ?array $formElementContainers = null;

    protected string $path = 'settings/factory/';

    protected ?string $groupName = null;

    public function setGroup($name): void
    {
        if ($config = config('admin_settings.groups.' . $name)) {
            $this->path = $config['path'];
            $this->groupName = $name;
            Seo::metaData()->setTitle('Настройки ' . $config['name']);
        }
    }

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
        foreach (new DirectoryIterator(app_path($this->path)) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            $config = require $fileInfo->getPathname();
            $filename = $fileInfo->getBasename('.' . $fileInfo->getExtension());
            if (isset($config['name'])) {
                $this->formElementContainers[$filename] = new FormElementsContainer(
                    key: $filename,
                    name: $config['name'],
                    visible: $config['visible'] ?? null,
                    elements: $config['data'],
                    groupName: $this->groupName,
                );
                if (!$this->formElementContainers[$filename]->isVisible()) unset($this->formElementContainers[$filename]);
            }
        }
        return $this->formElementContainers;
    }

    private function getOldSettings(): array
    {
        $path = app_path('/settings/' . ($this->groupName ?? 'settings') . '.json');
        if (is_file($path)) {
            $settings = json_decode(file_get_contents($path), true);
        }
        return $settings ?? [];
    }

    private function saveSettingsToFile($data): void
    {
        Cache::forget('admin_settings' . $this->groupName);
        file_put_contents(app_path('/settings/' . ($this->groupName ?? 'settings') . '.json'), json_encode($data));
    }
}
