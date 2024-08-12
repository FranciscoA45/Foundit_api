<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'posts',
            'id' => (string)$this->resource->getRouteKey(),
            'attributes' => [
                'title' => $this->title,
                'message' => $this->message,
                'slug' => $this->slug,
                'created_at' =>(new Carbon($this->created_at))->format('d-m-y H:i:s'),
                'updated_at' =>(new Carbon($this->updated_at))->format('d-m-Y H:i:s'),
            ],
            'links' => [
                'self' => route('api.posts.show', $this->resource)
            ], 
            'relationships'=>[
             
                'category' => new CategoryResource($this->whenLoaded('category')),
                'user' => new UserResource($this->whenLoaded('user')),
            ],
        ];
    }
}
