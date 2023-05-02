<?php

namespace Galtsevt\AppConf\app\Services\FormElementTypes;

class Select extends AbstractFormElement
{
    protected string $name;
    protected ?string $labelName;
    protected ?string $cssClass;
    protected ?string $cssId;
    protected array $data;

    public function __construct($name, array $params)
    {
        $this->name = $name;
        $this->labelName = $params['name'];
        $this->rules = $params['rules'] ?? null;
        $this->cssClass = $params['class'] ?? null;
        $this->cssId = $params['id'] ?? null;
        $this->data = is_callable($params['data']) ? call_user_func($params['data']) : $params['data'];
        $this->visible = isset($params['visible']) && is_callable($params['visible']) ? call_user_func($params['visible']):true;
    }


    public function preRender(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application|null
    {
            return view('appconf::components.select', [
                'name' => $this->name,
                'labelName' => $this->labelName,
                'cssClass' => $this->cssClass,
                'cssId' => $this->cssId,
                'data' => $this->data,
                'group' => $this->groupName,
            ]);
    }
}
