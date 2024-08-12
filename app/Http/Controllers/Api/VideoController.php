<?php

namespace App\Http\Controllers\Api;

use App\Models\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VideoCollection;
use App\Http\Resources\VideoResource;
use App\Models\Article;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos =Video::all();
        return new VideoCollection($videos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'slug' => 'required|string', 
            
        ]);

        $video = new Video();
        $video->title = $request->title;
        $video->description = $request->description;
        $video->slug = $request->slug;
     
        $video->save();

        return response()->json(new VideoResource($video));
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return VideoResource::make($video);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'slug' => 'required|string', 
        ]);

        
        $video->title = $request->title;
        $video->description = $request->description;
        $video->slug = $request->slug; 

        $video->save();

       
        return response()->json(new VideoResource($video));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        $video->delete();

        return response()->json(['message' => 'Eliminado']);
    }
}
