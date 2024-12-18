<?php

namespace Modules\Users\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Ограничиваем выводимые для фронта поля
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'comment' => $this->comment,
            'created_at' => $this->created_at->format('Y-m-d'),
        ];
    }
}
