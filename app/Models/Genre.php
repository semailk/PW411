<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property boolean $is_active
 */
class Genre extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active',
        'slug',
        'description',
    ];

    public function movies(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
}
