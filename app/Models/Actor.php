<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable('first_name', 'last_name', 'surname', 'photo', 'biography')]
class Actor extends Model
{
    use HasFactory;

    public function movies(): BelongsToMany
    {
        return $this->belongsToMany(Movie::class);
    }

    public function comments(): MorphMany  // ✅ MorphMany, не MorphToMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
