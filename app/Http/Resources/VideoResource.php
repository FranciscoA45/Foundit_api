<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray($request): array
     {
         return [
          
                 'type' => 'videos',
                 'id' => (string) $this->resource->getRouteKey(),
                 'attributes' => [
                    'title' => $this->title,
                    'description' => $this->description,
                    'slug' => $this->slug,
                    'created_at' => $this->created_at,
                    'update_at' => $this->updated_at,
                 ],
                 'links' => [
                     'self' => route('api.videos.show', $this->resource)
                 ]
             ];   
     }
 
     public function toResponse($request)
     {
         return parent::toResponse($request);
     }
     
}
