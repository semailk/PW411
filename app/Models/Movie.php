<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable(['title', 'genre_id', 'description', 'start_age', 'issue', 'time', 'cover'])]
class Movie extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function actors(): BelongsToMany
    {
        return $this->belongsToMany(Actor::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getCoverAttribute(): string
    {
        if (!$this->attributes['cover']) {
            return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtS0FPPO9ORTorlWvjV6J5DrO2Fc4sjP1gjQ&s';
        }
        return url($this->attributes['cover']);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useFallbackUrl('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQtS0FPPO9ORTorlWvjV6J5DrO2Fc4sjP1gjQ&s');
    }
}
