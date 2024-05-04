<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RolesResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'permissions' => $this->permissions->groupBy('group')->map(function ($permissions) {
                return $permissions->pluck('name')->unique()->toArray();
            }),
        ];
    }
}
