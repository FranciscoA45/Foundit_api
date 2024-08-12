<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'message',
        'category_id',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Boot function to add event listener for creating the slug.
     */
    protected static function boot()
    {
        parent::boot();
    
        static::creating(function ($post) {
            // Combine title with current date and a random unique identifier to generate the slug
            $slug = Str::slug($post->title . '-' . now()->format('Ymd') . '-' . Str::random(6));
            $post->slug = $slug;
        });
    }

    /**
     * Define the relationship with Category.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
