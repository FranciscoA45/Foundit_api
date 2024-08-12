<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        
        // Registro de datos
        Log::info('Categories: ', $categories->toArray());
        
        return CategoryResource::collection($categories);
    }

    public function show($id)
    {
        $category = Category::find($id);
        
        // Registro de datos
        Log::info('Category: ', $category ? $category->toArray() : []);
        
        return new CategoryResource($category);
    }
}
