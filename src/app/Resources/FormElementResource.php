<?php

namespace Galtsevt\AppConf\app\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormElementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->getName(),
            'value' => $this->getValue(),
            'config' => $this->getConfig(),
        ];
    }
}
