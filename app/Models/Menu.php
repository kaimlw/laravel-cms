<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Define relation menu item parent and children
     * Relation: (Web)One-to-Many(User)
     */
    public function parent() {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    /**
     * Define relation with Webs Table
     * Relation: (Web)One-to-Many(Menu)
     */
    public function web(): BelongsTo
    {
        return $this->belongsTo(Web::class);
    }
}
