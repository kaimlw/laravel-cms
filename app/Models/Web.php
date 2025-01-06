<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Web extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Define relation with User Table
     * Relation: (Web)One-to-Many(User)
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Define relation with Post Table
     * Relation: (Web)One-to-Many(Post)
     */
    public function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Define relation with Category Table
     * Relation: (Web)One-to-Many(Category)
     */
    public function category(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Define relation with Menu Table
     * Relation: (Web)One-to-Many(Menu)
     */
    public function menu(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
}
