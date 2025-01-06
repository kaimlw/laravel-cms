<?php

namespace App\Models;

use App\Models\Web;
use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Define relation with Desa Table
     * Relation: (Webs)One-to-Many(Category)
     */
    public function web(): BelongsTo
    {
        return $this->belongsTo(Web::class);
    }
    
    /**
     * Define relation with Category Table
     * Relation: Many-to-Many
     */
    public function post(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
