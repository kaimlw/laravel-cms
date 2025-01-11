<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Define relation with User Table
     * Relation: (User)One-to-Many(Post)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'author');
    }

    /**
     * Define relation with Category Table
     * Relation: Many-to-Many
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Define relation with Web Table
     * Relation: (Web)One-to-Many(Post)
     */
    public function web(): BelongsTo
    {
        return $this->belongsTo(Web::class);
    }
}
