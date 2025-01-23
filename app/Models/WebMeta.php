<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebMeta extends Model
{
    protected $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];

    /**
     * Define relation with Webs Table
     * Relation: (Web)One-to-Many(Media)
     */
    public function web(): BelongsTo
    {
        return $this->belongsTo(Web::class);
    }
}
