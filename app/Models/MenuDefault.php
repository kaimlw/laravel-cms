<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuDefault extends Model
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
        return $this->belongsTo(MenuDefault::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(MenuDefault::class, 'parent_id');
    }
}
