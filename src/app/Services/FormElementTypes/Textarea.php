<?php

namespace Galtsevt\AppConf\app\Services\FormElementTypes;

use Illuminate\Support\Facades\View;

class Textarea extends AbstractFormElement
{
    protected string $name;
    protected ?string $labelName;
    protected ?string $placeholder;
    protected ?string $cssClass;
    protected ?string $cssId;

    public function __construct($name, array $params)
    {
        $this->name = $name;
        $this->labelName = $params['name'];
        $this->placeholder = $params['placeholder'] ?? null;
        $this->rules = $params['rules'] ?? null;
        $this->cssClass = $params['class'] ?? null;
        $this->cssId = $params['id'] ?? null;
        $this->visible = isset($params['visible']) && is_callable($params['visible']) ? call_user_func($params['visible']) : true;
    }

    public function preRender(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|null
    {
        return view('appconf::components.textarea', [
            'name' => $this->name,
            'labelName' => $this->labelName,
            'placeholder' => $this->placeholder,
            'cssClass' => $this->cssClass,
            'cssId' => $this->cssId,
            'group' => $this->groupName,
        ]);
    }
}
