<?php

namespace Galtsevt\AppConf\app\Services\FormElementTypes;

abstract class AbstractFormElement
{
    protected string $rules;
    protected string $name;
    protected bool $visible = true;

    protected ?string $groupName = null;

    protected array $config = [];

    public function setGroupName($group): void
    {
        $this->groupName = $group;
    }

    public function getRules(): ?string
    {
        return $this->rules ?? 'nullable|string|max:200';
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): ?string
    {
        return settings($this->name, $this->groupName ?? null);
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function beforeSave($value): string
    {
        return $value;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

}
