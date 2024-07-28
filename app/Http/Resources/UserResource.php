<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        
        return [
            "id" => $this->id,
            'fullname' => $this->fullname,
            'username' => $this->username,
            'email' => $this->email,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
