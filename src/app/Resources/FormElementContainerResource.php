<?php

namespace Galtsevt\AppConf\app\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormElementContainerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'key' => $this->getKey(),
            'name' => $this->getName(),
            'formElements' => FormElementResource::collection($this->getFormElements()),
        ];
    }
}
