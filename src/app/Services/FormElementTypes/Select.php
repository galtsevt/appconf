<?php

namespace Galtsevt\AppConf\app\Services\FormElementTypes;

class Select extends AbstractFormElement
{
    protected string $name;

    public function __construct($name, array $params)
    {
        $this->name = $name;
        $this->rules = $params['rules'] ?? null;
        $this->config['labelName'] = $params['name'];
        $this->config['element'] = 'select';
        $this->config['data'] = is_callable($params['data']) ? call_user_func($params['data']) : $params['data'];
        $this->visible = isset($params['visible']) && is_callable($params['visible']) ? call_user_func($params['visible']) : true;
    }

}
