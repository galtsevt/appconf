<?php

namespace Galtsevt\AppConf\app\Services;

use Galtsevt\AppConf\app\Services\FormElementTypes\Input;

class FormElementsContainer
{
    protected string $key;
    protected string $name;
    protected bool $visible;
    protected array $formElements;
    protected array $allValidationRules;

    protected ?string $groupName = null;

    public function __construct(string $key, string $name, ?callable $visible, array $elements, ?string $groupName = null)
    {
        $this->key = $key;
        $this->name = $name;
        $this->groupName = $groupName;
        $this->visible = is_callable($visible) ? call_user_func($visible) : true;
        $this->createFormElements($elements);
    }

    private function createFormElements(array $elements): void
    {
        foreach ($elements as $key => $item) {
            $formElementType = '\Galtsevt\AppConf\app\Services\FormElementTypes\\' . ucfirst($item['type'] ?? 'input');
            $this->formElements[$key] = new $formElementType($key, $item);
            $this->formElements[$key]->setGroupName($this->groupName);
        }
    }

    public function beforeSave(array &$data): void
    {
        foreach ($this->formElements as $formElement) {
            if (isset($data[$formElement->getName()])) {
                $data[$formElement->getName()] = $formElement->beforeSave($data[$formElement->getName()]);
            }
        }
    }

    public function getAllValidationRules(): array
    {
        foreach ($this->formElements as $element) {
            if ($element->isVisible()) {
                $this->allValidationRules[$element->getName()] = $element->getRules();
            }
        }

        return $this->allValidationRules;
    }

    /**
     * @return array
     */
    public function getFormElements(): array
    {
        return $this->formElements ?? [];
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->visible;
    }
}
