<?php

namespace Tests\Feature;

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListVideosTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    public function can_fetch_a_single_video(): void
    {
        $this->withoutExceptionHandling();
        $video = Video::factory()->create();

        $response = $this->getJson(route('api.videos.show', $video));


        $response->assertExactJson([
            'data' => [
                'type' => 'videos',
                'id' => (string) $video->getRouteKey(),
                'attributes' => [
                    'title' => $video->title,
                    'description' => $video->description,
                    'slug' => $video->slug,
                    'created_at' => $video->created_at,
                    'update_at' => $video->updated_at,
                ],
                'links' => [
                    'self' => route('api.videos.show', $video)
                ]
            ]
        ])->dump();
    }

    /** @test */
    public function can_fetch_all_videos(): void
    {
        $this->withoutExceptionHandling();
        Video::factory()->count(5)->create();
        $response = $this->getJson(route('api.videos.index'));
        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'type',
                    'id',
                    'attributes' => [
                        'title',
                        'description',
                        'slug',
                        'created_at',
                        'update_at',
                    ],
                    'links' => [
                        'self',
                    ],
                ],
            ],
        ])->dump();
    }

    
}