<?php

namespace Galtsevt\AppConf\app\Services\FormElementTypes;

abstract class AbstractFormElement
{
    protected string $rules;
    protected string $name;
    protected bool $visible = true;

    protected ?string $groupName = null;

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

    public function beforeSave($value): string
    {
        return $value;
    }

    public function isVisible(): bool
    {
        return $this->visible;
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|null
    {
        if ($this->isVisible()) {
            return $this->preRender();
        }
        return null;
    }
}
