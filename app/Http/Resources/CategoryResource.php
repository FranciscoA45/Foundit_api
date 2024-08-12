<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'type' => 'categories',
            'id' => (string) $this->resource->getRouteKey(),
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'created_at' => $this->created_at->format('d-m-Y H:i:s'), // Adjust date format as needed
                'updated_at' => $this->updated_at,
            ],
            'links' => [
                'self' => route('api.categories.show', $this->resource), // Adjust route name as needed
            ],
        ];
    }
}
