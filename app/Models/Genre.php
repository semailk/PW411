<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property boolean $is_active
 */
class Genre extends Model
{
    protected $fillable = [
        'name',
        'is_active',
        'slug',
        'description',
    ];
}
