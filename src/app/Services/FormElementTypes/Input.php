<?php

namespace Galtsevt\AppConf\app\Services\FormElementTypes;

use Illuminate\Support\Facades\View;

class Input extends AbstractFormElement
{
    protected string $name;


    public function __construct($name, array $params)
    {
        $this->name = $name;
        $this->rules = $params['rules'] ?? null;
        $this->config['labelName'] = $params['name'];
        $this->config['placeholder'] = $params['placeholder'] ?? null;
        $this->config['type'] = $params['type'] ?? 'text';
        $this->config['element'] = 'input';
        $this->visible = isset($params['visible']) && is_callable($params['visible']) ? call_user_func($params['visible']) : true;
    }

}
